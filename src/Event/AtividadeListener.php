<?php
// src/Event/AtividadeListener.php
declare(strict_types=1);

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\I18n\Date; // Importa a classe Date
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
// use Cake\ORM\Query; // Importar se você usar finders customizados ou Query, mas não necessário para este código.

class AtividadeListener implements EventListenerInterface
{
    use LocatorAwareTrait; // Permite usar $this->fetchTable()

    /**
     * Retorna uma lista de eventos que este listener está observando.
     *
     * @return array
     */
    public function implementedEvents(): array
    {
        return [
            // Ouve o evento 'Model.afterSave' disparado por qualquer modelo.
            // O segundo parâmetro 'gerarAulasEMatricularAlunos' é o método que será chamado.
            'Model.afterSave' => 'gerarAulasEMatricularAlunos',
        ];
    }

    /**
     * Gera aulas e matricula alunos após a atividade ser salva.
     * Este método é acionado pelo evento 'Model.afterSave'.
     *
     * @param \Cake\Event\EventInterface $event O objeto evento.
     * @param \App\Model\Entity\Atividade $entity A entidade Atividade que foi salva.
     * @param \ArrayObject $options As opções passadas para o save.
     * @return void
     */
    public function gerarAulasEMatricularAlunos($event, $entity, \ArrayObject $options): void
    {
        // Verifica se a entidade que disparou o evento é uma Atividade e se é nova
        // OU se as datas de início/fim foram modificadas (para regenerar as aulas).
        if ($entity->getSource() === 'Atividades' && ($entity->isNew() || $entity->isDirty('data_inicio') || $entity->isDirty('data_fim'))) {
            $idAtividade = $entity->id;
            // Certifique-se que $entity->data_inicio e $entity->data_fim são objetos Cake\I18n\Date
            // e que eles realmente existem e têm valores.
            if (empty($entity->data_inicio) || empty($entity->data_fim)) {
                // Poderíamos logar um erro ou lançar uma exceção se as datas forem nulas.
                // Por enquanto, apenas retorna para evitar erros.
                return;
            }

            $dataInicio = $entity->data_inicio;
            $dataFim = $entity->data_fim;

            // Instancia as tabelas necessárias via LocatorAwareTrait ($this->fetchTable())
            $aulasTable = $this->fetchTable('Aulas');
            $inscricoesTable = $this->fetchTable('Inscricoes');
            $presencasTable = $this->fetchTable('Presencas');

            $connection = ConnectionManager::get('default');

            // O método transactional() já encapsula a lógica de try/catch e rollback/commit.
            // Se uma exceção for lançada dentro do callback, ele fará o rollback de todas as operações.
            $connection->transactional(function () use ($idAtividade, $dataInicio, $dataFim, $aulasTable, $inscricoesTable, $presencasTable, $entity) {

                // 1. Remover aulas e associações de alunos existentes se as datas mudaram
                // ou se a atividade foi editada (e não é nova).
                if (!$entity->isNew()) {
                    // Pega os IDs das aulas antigas desta atividade
                    $aulasAntigasIds = $aulasTable->find()
                        ->select(['id'])
                        ->where(['atividade_id' => $idAtividade])
                        ->extract('id') // Extrai apenas os IDs para um array simples
                        ->toArray();

                    if (!empty($aulasAntigasIds)) {
                        // Primeiro, remove os registros de presença associados às aulas antigas
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
                // CORREÇÃO AQUI: Usar o operador de comparação <= em vez de ->lte()
                while ($currentDate <= $endDate) {
                    // Exemplo: apenas dias úteis (segunda a sexta)
                    // Adapte isso se você tiver um campo 'dias_semana' na sua atividade e precisar de lógica mais complexa.
                    if ($currentDate->isWeekday()) {
                        $aula = $aulasTable->newEmptyEntity();
                        $aula->atividade_id = $idAtividade;
                        $aula->data = $currentDate->format('Y-m-d'); // Use o nome real da coluna 'data'
                        $aulasParaSalvar[] = $aula;
                    }
                    $currentDate = $currentDate->addDays(1); // Avança para o próximo dia
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
                                $presencasParaSalvar[] = $presenca;
                            }
                        }
                        // Salva todas as novas entradas de presença em massa
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