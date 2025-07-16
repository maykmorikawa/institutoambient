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
        $this->loadModel('Aulas');
        $this->loadModel('Alunos');
        $this->loadModel('Atividades'); // Carregado para obter o nome da atividade da aula

        // Validação básica do ID da aula
        if (empty($aulaId) || !is_numeric($aulaId)) {
            $this->Flash->error(__('ID da aula inválido.'));
            return $this->redirect(['controller' => 'Aulas', 'action' => 'index']);
        }

        try {
            $aula = $this->Aulas->get($aulaId, ['contain' => ['Atividades']]); // Carregar Atividade
        } catch (NotFoundException $e) { // Capturar a exceção de registro não encontrado
            $this->Flash->error(__('Aula não encontrada.'));
            return $this->redirect(['controller' => 'Aulas', 'action' => 'index']);
        }

        // Recupera todos os alunos associados a esta Atividade
        // Cenário 1 (assumindo Aluno tem atividade_id):
        $alunosDaAtividade = $this->Alunos->find('all')
            ->where(['Alunos.atividade_id' => $aula->atividade->id])
            ->order(['Alunos.nome_completo' => 'ASC']) // Opcional: ordenar alunos
            ->toArray();

        // Cenário 2 (se Aluno tem belongsToMany Atividades):
        /*
        $alunosDaAtividade = $this->Alunos->find('all')
            ->matching('Atividades', function ($q) use ($aula) {
                return $q->where(['Atividades.id' => $aula->atividade->id]);
            })
            ->order(['Alunos.nome_completo' => 'ASC'])
            ->toArray();
        */

        // Carrega presenças já registradas para esta aula para preencher o formulário
        // Usar um array de entidades para facilitar a renderização no formulário
        $presencasRegistradas = $this->Presencas->find('all')
            ->where(['aula_id' => $aulaId])
            ->indexBy('aluno_id') // Indexa por aluno_id para fácil acesso
            ->toArray();

        $this->set(compact('aula', 'alunosDaAtividade', 'presencasRegistradas'));
        // Sem lógica de POST aqui, apenas renderiza o formulário
    }

    /**
     * Ação AJAX para atualizar a presença de um único aluno.
     */
    public function updatePresenceAjax()
    {
        $this->request->allowMethod(['post']); // Apenas permite requisições POST

        $alunoId = $this->request->getData('aluno_id');
        $aulaId = $this->request->getData('aula_id');
        $presente = (bool)$this->request->getData('presente'); // Converte para booleano

        $this->loadModel('Presencas');

        // Tenta encontrar uma presença existente para o aluno e aula
        $presenca = $this->Presencas->find()
            ->where([
                'aluno_id' => $alunoId,
                'aula_id' => $aulaId
            ])
            ->first();

        if (!$presenca) {
            $presenca = $this->Presencas->newEntity([
                'aluno_id' => $alunoId,
                'aula_id' => $aulaId,
            ]);
        }

        $presenca->presente = $presente;

        if ($this->Presencas->save($presenca)) {
            $this->set([
                'status' => 'success',
                'message' => __('Presença atualizada com sucesso.'),
                '_serialize' => ['status', 'message'] // Retorna JSON
            ]);
        } else {
            $this->set([
                'status' => 'error',
                'message' => __('Erro ao atualizar a presença.'),
                'errors' => $presenca->getErrors(), // Retorna erros de validação, se houver
                '_serialize' => ['status', 'message', 'errors'] // Retorna JSON
            ]);
            $this->response = $this->response->withStatus(400); // Bad Request
        }

        $this->viewBuilder()->setOption('serialize', true); // Configura para serializar a view
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
