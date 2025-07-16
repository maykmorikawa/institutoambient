<?php
// src/Event/AtividadeListener.php
namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query; // Importar para o finder

class AtividadeListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    public function implementedEvents(): array
    {
        return [
            'Model.afterSave' => 'gerarAulasEMatricularAlunos',
        ];
    }

    public function gerarAulasEMatricularAlunos($event, $entity, $options)
    {
        // Verifica se é uma entidade de Atividade e se as datas foram alteradas ou é nova
        if ($entity->getSource() === 'Atividades' && ($entity->isNew() || $entity->isDirty('data_inicio') || $entity->isDirty('data_fim'))) {
            $idAtividade = $entity->id;
            $dataInicio = $entity->data_inicio;
            $dataFim = $entity->data_fim;

            $atividadesTable = $this->fetchTable('Atividades');
            $aulasTable = $this->fetchTable('Aulas');
            $inscricoesTable = $this->fetchTable('Inscricoes'); // Novo: Tabela de inscrições
            $presencasTable = $this->fetchTable('Presencas'); // Sua tabela de presenças

            $connection = ConnectionManager::get('default');

            // Inicia uma transação
            $connection->begin();
            try {

                // 1. Remover aulas e associações de alunos existentes se as datas mudaram
                if (!$entity->isNew()) {
                    // Pega os IDs das aulas antigas desta atividade
                    $aulasAntigasIds = $aulasTable->find()
                        ->select(['id'])
                        ->where(['atividade_id' => $idAtividade])
                        ->extract('id') // Extrai apenas os IDs para um array simples
                        ->toArray();

                    if (!empty($aulasAntigasIds)) {
                        // Primeiro, remove as presenças (associações de alunos) das aulas antigas
                        $presencasTable->deleteAll(['aula_id IN' => $aulasAntigasIds]);
                        // Depois, remove as aulas em si
                        $aulasTable->deleteAll(['id' => $aulasAntigasIds]);
                    }
                }

                $aulasParaSalvar = [];
                $dataAtual = new Date($dataInicio);
                $dataFinal = new Date($dataFim);

                // 2. Gerar as novas aulas
                while ($dataAtual->lte($dataFinal)) {
                    if ($dataAtual->isWeekday()) { // Exemplo: apenas dias úteis
                        $aula = $aulasTable->newEmptyEntity();
                        $aula->atividade_id = $idAtividade; // Use o nome do campo real
                        $aula->data = $dataAtual->format('Y-m-d'); // Use o nome do campo real
                        $aulasParaSalvar[] = $aula;
                    }
                    $dataAtual = $dataAtual->addDays(1);
                }

                if (!empty($aulasParaSalvar)) {
                    // Salvar as aulas. O saveMany retornará as entidades com IDs.
                    $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

                    // 3. Obter os alunos ATIVAMENTE inscritos nesta atividade através da tabela `inscricoes`
                    $alunosInscritos = $inscricoesTable->find()
                        ->select(['Alunos.id']) // Seleciona apenas o ID do aluno
                        ->contain(['Alunos']) // Carrega a associação com Alunos
                        ->where([
                            'Inscricoes.atividade_id' => $idAtividade,
                            'Inscricoes.status' => 'confirmada' // Filtra por status 'confirmada'
                        ])
                        ->all()
                        ->collection()
                        ->extract('Alunos.id') // Extrai apenas os IDs dos alunos
                        ->toList();

                    if (!empty($alunosInscritos) && !empty($savedAulas)) {
                        $presencasParaSalvar = [];
                        foreach ($savedAulas as $aula) {
                            foreach ($alunosInscritos as $alunoId) {
                                // Cria uma nova entidade de presença (associação aula-aluno)
                                $presenca = $presencasTable->newEmptyEntity();
                                $presenca->aula_id = $aula->id;
                                $presenca->aluno_id = $alunoId;
                                $presenca->presente = 0; // Define como não presente por padrão
                                // Outros campos como observacoes podem ser nulos ou preenchidos
                                $presencasParaSalvar[] = $presenca;
                            }
                        }
                        $presencasTable->saveMany($presencasParaSalvar);
                    }
                }
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollback();
            throw $e;
        }
    }
}