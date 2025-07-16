<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenDate; // Certifique-se de que está importado
use Cake\Http\Exception\NotFoundException; // Importar para exceções de record not found

/**
 * Presencas Controller
 *
 * @property \App\Model\Table\PresencasTable $Presencas
 */
class PresencasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Presencas->find()
            ->contain(['Aulas', 'Alunos']);
        $presencas = $this->paginate($query);

        $this->set(compact('presencas'));
    }

    /**
     * View method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $presenca = $this->Presencas->get($id, contain: ['Aulas', 'Alunos']);
        $this->set(compact('presenca'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $presenca = $this->Presencas->newEmptyEntity();
        if ($this->request->is('post')) {
            $presenca = $this->Presencas->patchEntity($presenca, $this->request->getData());
            if ($this->Presencas->save($presenca)) {
                $this->Flash->success(__('The presenca has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presenca could not be saved. Please, try again.'));
        }
        $aulas = $this->Presencas->Aulas->find('list', limit: 200)->all();
        $alunos = $this->Presencas->Alunos->find('list', limit: 200)->all();
        $this->set(compact('presenca', 'aulas', 'alunos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $presenca = $this->Presencas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $presenca = $this->Presencas->patchEntity($presenca, $this->request->getData());
            if ($this->Presencas->save($presenca)) {
                $this->Flash->success(__('The presenca has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The presenca could not be saved. Please, try again.'));
        }
        $aulas = $this->Presencas->Aulas->find('list', limit: 200)->all();
        $alunos = $this->Presencas->Alunos->find('list', limit: 200)->all();
        $this->set(compact('presenca', 'aulas', 'alunos'));
    }

    public function registrar($aulaId = null)
    {
        // **CakePHP 5.1: Carregando modelos com fetchTable()**
        $aulasTable = $this->fetchTable('Aulas');
        $alunosTable = $this->fetchTable('Alunos');
        // A tabela 'Atividades' é carregada via 'contain' na aula, não é necessário carregá-la separadamente aqui.
        // $atividadesTable = $this->fetchTable('Atividades');

        // Validação básica do ID da aula
        if (empty($aulaId) || !is_numeric($aulaId)) {
            $this->Flash->error(__('ID da aula inválido. Por favor, forneça um ID de aula válido.'));
            return $this->redirect(['controller' => 'Aulas', 'action' => 'index']);
        }

        try {
            // Carrega a aula e sua atividade associada
            $aula = $aulasTable->get($aulaId, ['contain' => ['Atividades']]);
        } catch (RecordNotFoundException $e) { // **Use RecordNotFoundException no CakePHP 5.1**
            $this->Flash->error(__('Aula não encontrada. O ID fornecido não corresponde a nenhuma aula existente.'));
            return $this->redirect(['controller' => 'Aulas', 'action' => 'index']);
        }

        // Recupera todos os alunos associados a esta Atividade
        // Cenário 1 (assumindo Aluno tem atividade_id):
        // Esta é a abordagem mais simples se a relação é direta (Aluno possui um atividade_id)
        $alunosDaAtividade = $alunosTable->find('all')
            ->where(['Alunos.atividade_id' => $aula->atividade->id])
            ->order(['Alunos.nome_completo' => 'ASC']) // Opcional: ordenar alunos
            ->toArray();

        // Cenário 2 (se Aluno tem belongsToMany Atividades):
        // Se a relação entre Alunos e Atividades for Many-to-Many (tabela pivot), use o 'matching'
        /*
        $alunosDaAtividade = $alunosTable->find('all')
            ->matching('Atividades', function ($q) use ($aula) {
                return $q->where(['Atividades.id' => $aula->atividade->id]);
            })
            ->order(['Alunos.nome_completo' => 'ASC'])
            ->toArray();
        */

        // Carrega presenças já registradas para esta aula para preencher o formulário
        $presencasRegistradas = $this->Presencas->find('all')
            ->where(['aula_id' => $aulaId])
            ->indexBy('aluno_id') // Indexa por aluno_id para fácil acesso na view
            ->toArray();

        $this->set(compact('aula', 'alunosDaAtividade', 'presencasRegistradas'));
        // Sem lógica de POST aqui, apenas renderiza o formulário
    }

    /**
     * Ação AJAX para atualizar a presença de um único aluno.
     * Retorna JSON.
     *
     * @return \Cake\Http\Response|null
     */
    public function updatePresenceAjax()
    {
        // Certifica-se de que a requisição é POST
        $this->request->allowMethod(['post']);

        // Recupera os dados enviados via AJAX
        $alunoId = $this->request->getData('aluno_id');
        $aulaId = $this->request->getData('aula_id');
        // Converte para booleano: '1' ou 'true' vira true, '0' ou 'false' vira false
        $presente = (bool)$this->request->getData('presente');

        // O modelo Presencas já deve estar disponível via $this->Presencas
        // Se não estiver (ex: se PresencasController não for o Controller principal para Presencas),
        // use $this->fetchTable('Presencas');
        // $presencasTable = $this->fetchTable('Presencas'); // Exemplo, se necessário

        // Tenta encontrar uma presença existente para o aluno e aula
        $presenca = $this->Presencas->find()
            ->where([
                'aluno_id' => $alunoId,
                'aula_id' => $aulaId
            ])
            ->first();

        // Se não encontrar, cria uma nova entidade de presença
        if (!$presenca) {
            $presenca = $this->Presencas->newEmptyEntity(); // **Use newEmptyEntity() no CakePHP 5.1**
            $presenca->aluno_id = $alunoId;
            $presenca->aula_id = $aulaId;
        }

        // Atualiza o status de presença
        $presenca->presente = $presente;

        // Tenta salvar a presença
        if ($this->Presencas->save($presenca)) {
            $response = [
                'status' => 'success',
                'message' => __('Presença atualizada com sucesso.'),
                'presencaId' => $presenca->id // Útil para o front-end
            ];
            $this->response = $this->response->withStatus(200); // OK
        } else {
            // Em caso de erro, retorna status de erro e detalhes
            $response = [
                'status' => 'error',
                'message' => __('Erro ao atualizar a presença. Verifique os dados e tente novamente.'),
                'errors' => $presenca->getErrors(), // Retorna erros de validação
            ];
            $this->response = $this->response->withStatus(400); // Bad Request
        }

        // Configura a resposta para JSON
        $this->setResponse($this->response->withType('application/json'));
        $this->set(compact('response'));
        $this->viewBuilder()->setOption('serialize', 'response'); // Serializa a variável 'response'
    }


    /**
     * Delete method
     *
     * @param string|null $id Presenca id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $presenca = $this->Presencas->get($id);
        if ($this->Presencas->delete($presenca)) {
            $this->Flash->success(__('The presenca has been deleted.'));
        } else {
            $this->Flash->error(__('The presenca could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
