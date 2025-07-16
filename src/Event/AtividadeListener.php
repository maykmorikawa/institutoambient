<?php
// src/Event/AtividadeListener.php
declare(strict_types=1); // Boa prática para type hints mais rigorosos

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\I18n\Date;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Query; // Importar se você usar finders customizados ou Query

class AtividadeListener implements EventListenerInterface
{
    use LocatorAwareTrait;

    public function implementedEvents(): array
    {
        return [
            // Garanta que o nome do evento e o método sejam consistentes
            'Model.afterSave' => 'gerarAulasEMatricularAlunos',
        ];
    }

    /**
     * Gera aulas e matricula alunos após a atividade ser salva.
     *
     * @param \Cake\Event\EventInterface $event O objeto evento.
     * @param \App\Model\Entity\Atividade $entity A entidade Atividade que foi salva.
     * @param \ArrayObject $options As opções passadas para o save.
     * @return void
     */
    public function gerarAulasEMatricularAlunos($event, $entity, $options)
    {
        // Verifica se a entidade é uma Atividade e se as datas de início/fim foram alteradas ou é uma nova atividade.
        // O `getSource()` retorna o nome da Table class (ex: 'Atividades').
        if ($entity->getSource() === 'Atividades' && ($entity->isNew() || $entity->isDirty('data_inicio') || $entity->isDirty('data_fim'))) {
            $idAtividade = $entity->id;
            // Certifique-se que esses campos existem na sua entidade Atividade e são objetos Date
            $dataInicio = $entity->data_inicio;
            $dataFim = $entity->data_fim;

            // Instancia as tabelas necessárias via LocatorAwareTrait
            $atividadesTable = $this->fetchTable('Atividades');
            $aulasTable = $this->fetchTable('Aulas');
            $inscricoesTable = $this->fetchTable('Inscricoes');
            $presencasTable = $this->fetchTable('Presencas');

            $connection = ConnectionManager::get('default');

            // O método transactional() já encapsula a lógica de try/catch e rollback/commit.
            // Se uma exceção for lançada dentro do callback, ele fará o rollback.
            // Não é necessário um try/catch externo aqui para o rollback.
            $connection->transactional(function () use ($idAtividade, $dataInicio, $dataFim, $atividadesTable, $aulasTable, $inscricoesTable, $presencasTable, $entity) {

                // 1. Remover aulas e associações de alunos existentes se as datas mudaram (ou se não for nova atividade)
                // Usamos !isNew() para garantir que só tentamos remover aulas se a atividade já existia.
                if (!$entity->isNew()) {
                    // Pega os IDs das aulas antigas desta atividade
                    $aulasAntigasIds = $aulasTable->find()
                        ->select(['id'])
                        ->where(['atividade_id' => $idAtividade])
                        ->extract('id') // Extrai apenas os IDs para um array simples
                        ->toArray();

                    if (!empty($aulasAntigasIds)) {
                        // Primeiro, remove as presenças (associações de alunos) das aulas antigas
                        // Isso é importante para evitar erros de chave estrangeira ao deletar as aulas
                        $presencasTable->deleteAll(['aula_id IN' => $aulasAntigasIds]);
                        // Depois, remove as aulas em si
                        $aulasTable->deleteAll(['id IN' => $aulasAntigasIds]); // Use IN para deletar múltiplos
                    }
                }

                $aulasParaSalvar = [];
                // Garante que $dataInicio e $dataFim são objetos Cake\I18n\Date
                $currentDate = new Date($dataInicio);
                $endDate = new Date($dataFim);

                // 2. Gerar as novas aulas
                while ($currentDate->lte($endDate)) {
                    // Exemplo: apenas dias úteis (segunda a sexta)
                    // Adapte isso se você tiver um campo 'dias_semana' na sua atividade e precisar de lógica mais complexa.
                    if ($currentDate->isWeekday()) {
                        $aula = $aulasTable->newEmptyEntity();
                        $aula->atividade_id = $idAtividade;
                        $aula->data = $currentDate->format('Y-m-d'); // Use o nome real da coluna 'data'
                        $aulasParaSalvar[] = $aula;
                    }
                    $currentDate = $currentDate->addDays(1);
                }

                if (!empty($aulasParaSalvar)) {
                    // Salvar as aulas. O saveMany retornará as entidades salvas com seus IDs (se AUTO_INCREMENT).
                    $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

                    // 3. Obter os IDs dos alunos ATIVAMENTE inscritos nesta atividade através da tabela `inscricoes`
                    // Optamos por buscar apenas os IDs para otimização.
                    $alunosInscritosIds = $inscricoesTable->find()
                        ->select(['Inscricoes.aluno_id']) // Seleciona apenas o ID do aluno da tabela de junção 'inscricoes'
                        ->where([
                            'Inscricoes.atividade_id' => $idAtividade,
                            'Inscricoes.status' => 'confirmada' // Filtra apenas inscrições com status 'confirmada'
                        ])
                        ->extract('aluno_id') // Extrai os valores do campo 'aluno_id' para um array simples
                        ->toArray();

                    if (!empty($alunosInscritosIds) && !empty($savedAulas)) {
                        $presencasParaSalvar = [];
                        foreach ($savedAulas as $aula) {
                            foreach ($alunosInscritosIds as $alunoId) {
                                // Cria uma nova entidade de presença (que associa aula e aluno)
                                $presenca = $presencasTable->newEmptyEntity();
                                $presenca->aula_id = $aula->id;
                                $presenca->aluno_id = $alunoId;
                                $presenca->presente = 0; // Define o padrão como não presente
                                // Adicione outros campos padrão se houver (ex: observacoes = null)
                                $presencasParaSalvar[] = $presenca;
                            }
                        }
                        // Salva todas as novas entradas de presença em massa
                        // saveMany é mais eficiente para múltiplos registros.
                        if (!$presencasTable->saveMany($presencasParaSalvar)) {
                            // Se o saveMany falhar (ex: validação), lança uma exceção para acionar o rollback
                            throw new \Exception(__('Falha ao matricular alunos nas aulas.'));
                        }
                    }
                }
            });
        }
    }
}