<?php
// src/Event/AtividadeListener.php
declare(strict_types=1); // Força a verificação rigorosa de tipos

namespace App\Event;

use Cake\Event\EventListenerInterface;
use Cake\I18n\Date; // Importa a classe Date para trabalhar com datas
use Cake\ORM\Locator\LocatorAwareTrait; // Permite usar $this->fetchTable()
use Cake\Datasource\ConnectionManager; // Importa para gerenciar transações no banco de dados
// use Cake\ORM\Query; // Não é necessário para este código, mas útil para finders customizados

class AtividadeListener implements EventListenerInterface
{
    use LocatorAwareTrait; // Habilita o uso de $this->fetchTable() para acessar outras tabelas

    /**
     * Retorna uma lista de eventos que este listener está observando.
     *
     * @return array Um array associativo onde as chaves são os nomes dos eventos
     * e os valores são os nomes dos métodos a serem chamados.
     */
    public function implementedEvents(): array
    {
        return [
            // Ouve o evento 'Model.afterSave' que é disparado após um modelo ser salvo.
            // O método 'gerarAulasEMatricularAlunos' será chamado quando este evento ocorrer.
            'Model.afterSave' => 'gerarAulasEMatricularAlunos',
        ];
    }

    /**
     * Gera aulas e matricula alunos automaticamente após uma atividade ser salva ou atualizada.
     * Este método é acionado pelo evento 'Model.afterSave'.
     *
     * @param \Cake\Event\EventInterface $event O objeto evento que contém informações sobre o evento disparado.
     * @param \App\Model\Entity\Atividade $entity A entidade Atividade que foi salva ou atualizada.
     * @param \ArrayObject $options As opções passadas para o método save() que disparou o evento.
     * @return void
     */
    public function gerarAulasEMatricularAlunos($event, $entity, \ArrayObject $options): void
    {
        // Verifica se a entidade que disparou o evento é uma 'Atividade'
        // E se a atividade é nova OU se as datas de início/fim foram modificadas.
        // Isso garante que a lógica de geração de aulas só seja executada quando relevante.
        if ($entity->getSource() === 'Atividades' && ($entity->isNew() || $entity->isDirty('data_inicio') || $entity->isDirty('data_fim'))) {
            $idAtividade = $entity->id;

            // Validação básica para garantir que as datas existam antes de prosseguir.
            // Se as datas não estiverem presentes, não há como gerar as aulas.
            if (empty($entity->data_inicio) || empty($entity->data_fim)) {
                // Em um ambiente de produção, você poderia logar isso como um erro.
                // Para depuração, um debug() ou um simples return é suficiente.
                // debug('Datas de início ou fim da atividade estão ausentes. Não é possível gerar aulas.');
                return;
            }

            // Atribui as datas da entidade a variáveis locais para clareza
            $dataInicio = $entity->data_inicio;
            $dataFim = $entity->data_fim;

            // Obtém instâncias das tabelas necessárias usando o trait LocatorAwareTrait (fetchTable()).
            // Isso permite interagir com outras tabelas do banco de dados.
            $aulasTable = $this->fetchTable('Aulas');
            $inscricoesTable = $this->fetchTable('Inscricoes');
            $presencasTable = $this->fetchTable('Presencas');
            // $alunosTable = $this->fetchTable('Alunos'); // Pode ser útil, mas não diretamente usado aqui.

            $connection = ConnectionManager::get('default'); // Obtém a conexão padrão do banco de dados

            // Inicia uma transação no banco de dados.
            // O método transactional() garante que todas as operações dentro do callback
            // sejam tratadas como uma única unidade atômica. Se qualquer parte falhar (lançar exceção),
            // todas as alterações são revertidas (rollback). Caso contrário, são confirmadas (commit).
            $connection->transactional(function () use ($idAtividade, $dataInicio, $dataFim, $aulasTable, $inscricoesTable, $presencasTable, $entity) {

                // 1. Lógica para remover aulas e associações de presença existentes.
                // Isso é crucial quando uma atividade é EDITADA e suas datas são alteradas,
                // para evitar aulas duplicadas ou desatualizadas.
                if (!$entity->isNew()) { // Se a atividade NÃO é nova (ou seja, está sendo editada)
                    // Primeiro, busca os IDs de todas as aulas associadas a esta atividade.
                    $aulasAntigasIds = $aulasTable->find()
                        ->select(['id'])
                        ->where(['atividade_id' => $idAtividade])
                        ->extract('id') // Extrai apenas os IDs para um array simples (ex: [1, 5, 9])
                        ->toArray();

                    if (!empty($aulasAntigasIds)) {
                        // Se houver aulas antigas, primeiro remove os registros de presença
                        // associados a essas aulas. Isso evita erros de chave estrangeira.
                        $presencasTable->deleteAll(['aula_id IN' => $aulasAntigasIds]);
                        // Em seguida, remove as próprias aulas antigas.
                        $aulasTable->deleteAll(['id IN' => $aulasAntigasIds]);
                    }
                }

                $aulasParaSalvar = []; // Array para armazenar as novas entidades de Aula
                $currentDate = new Date($dataInicio); // Cria um objeto Date para a data de início
                $endDate = new Date($dataFim);       // Cria um objeto Date para a data de fim

                // 2. Lógica para gerar as novas aulas para o período da atividade.
                // O loop itera dia a dia da data de início até a data de fim.
                // CORREÇÃO APLICADA: Usando o operador de comparação '<=' para objetos Date.
                while ($currentDate <= $endDate) {
                    // Exemplo de regra: Gerar aulas apenas para dias de semana (segunda a sexta).
                    // Você pode expandir esta lógica para considerar campos como 'dias_semana'
                    // na sua tabela 'atividades' para uma programação mais flexível.
                    if ($currentDate->isWeekday()) {
                        $aula = $aulasTable->newEmptyEntity(); // Cria uma nova entidade Aula
                        $aula->atividade_id = $idAtividade;    // Associa a aula à atividade atual
                        $aula->data = $currentDate->format('Y-m-d'); // Define a data da aula no formato YYYY-MM-DD
                        $aulasParaSalvar[] = $aula; // Adiciona a aula à lista para salvamento em massa
                    }
                    $currentDate = $currentDate->addDays(1); // Avança para o próximo dia
                }

                if (!empty($aulasParaSalvar)) {
                    // Salva todas as entidades de Aula geradas no banco de dados em uma única operação.
                    // saveMany retorna as entidades salvas, que agora terão seus IDs preenchidos.
                    $savedAulas = $aulasTable->saveMany($aulasParaSalvar);

                    // 3. Lógica para obter os alunos já inscritos e matriculá-los nas aulas geradas.
                    // Busca os IDs dos alunos que possuem uma inscrição 'confirmada' para esta atividade.
                    // CORREÇÃO APLICADA: Adicionado ->all() antes de ->extract() para executar a query.
                    $alunosInscritosIds = $inscricoesTable->find()
                        ->select(['Inscricoes.aluno_id']) // Seleciona apenas o campo 'aluno_id' da tabela 'inscricoes'
                        ->where([
                            'Inscricoes.atividade_id' => $idAtividade,
                            'Inscricoes.status' => 'confirmada' // Filtra para incluir apenas inscrições com status 'confirmada'
                        ])
                        ->all() // Executa a consulta e retorna um ResultSet (coleção de entidades)
                        ->extract('aluno_id') // Extrai o valor do campo 'aluno_id' de cada entidade para um array simples
                        ->toArray(); // Converte o resultado em um array PHP nativo

                    if (!empty($alunosInscritosIds) && !empty($savedAulas)) {
                        $presencasParaSalvar = []; // Array para armazenar as novas entidades de Presenca
                        // Itera sobre cada aula que foi salva
                        foreach ($savedAulas as $aula) {
                            // Para cada aula, itera sobre cada aluno que está inscrito na atividade
                            foreach ($alunosInscritosIds as $alunoId) {
                                $presenca = $presencasTable->newEmptyEntity(); // Cria uma nova entidade Presenca
                                $presenca->aula_id = $aula->id;                 // Associa a presença à aula recém-criada
                                $presenca->aluno_id = $alunoId;                 // Associa a presença ao aluno
                                $presenca->presente = 0;                        // Define o status inicial de presença como "não presente" (0 ou false)
                                // Você pode adicionar outros campos padrão aqui, se sua tabela 'presencas' os tiver.
                                $presencasParaSalvar[] = $presenca;             // Adiciona à lista para salvamento em massa
                            }
                        }
                        // Salva todas as novas entidades de Presenca no banco de dados em uma única operação.
                        if (!$presencasTable->saveMany($presencasParaSalvar)) {
                            // Se o saveMany falhar (ex: erro de validação ou banco de dados),
                            // lança uma exceção para que a transação seja revertida automaticamente.
                            throw new \Exception(__('Falha ao matricular alunos nas aulas.'));
                        }
                    }
                }
            });
        }
    }
}
