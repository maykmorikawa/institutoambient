<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Inscricoes Controller
 *
 * @property \App\Model\Table\InscricoesTable $Inscricoes
 */
class InscricoesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }

    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['verificar', 'processarInscricao']);
    }

    /**
     * Ação para verificação de cadastro
     */
    public function verificar($slug = null)
    {
        // Usando fetchTable() em vez de loadModel()
        $atividade = $this->fetchTable('Atividades')
            ->findBySlug($slug)
            ->firstOrFail();

        if ($this->request->is('post')) {
            $cpf = preg_replace('/[^0-9]/', '', $this->request->getData('cpf'));
            $dataNascimento = $this->request->getData('data_nascimento');

            $aluno = $this->fetchTable('Alunos')
                ->find()
                ->where([
                    'cpf' => $cpf,
                    'data_nascimento' => $dataNascimento
                ])
                ->first();

            if ($aluno) {
                return $this->redirect([
                    'action' => 'processarInscricao',
                    'atividade_id' => $atividade->id,
                    'aluno_id' => $aluno->id
                ]);
            } else {
                $this->Flash->error('Cadastro não encontrado. Por favor, cadastre-se.');
                return $this->redirect([
                    'controller' => 'Alunos',
                    'action' => 'add',
                    '?' => ['atividade_id' => $atividade->id]
                ]);
            }
        }

        $this->set(compact('atividade'));
        $this->viewBuilder()->setLayout('site');
    }

    /**
     * Processa a inscrição após verificação
     */
    public function processarInscricao()
    {
        $atividadeId = $this->request->getQuery('atividade_id');
        $alunoId = $this->request->getQuery('aluno_id');

        $inscricaoExistente = $this->fetchTable('Inscricoes')
            ->find()
            ->where([
                'aluno_id' => $alunoId,
                'atividade_id' => $atividadeId
            ])
            ->first();

        if ($inscricaoExistente) {
            $this->Flash->warning('Você já está inscrito nesta atividade.');
            return $this->redirect([
                'controller' => 'Atividades',
                'action' => 'view',
                $atividadeId
            ]);
        }

        $inscricao = $this->fetchTable('Inscricoes')->newEntity([
            'aluno_id' => $alunoId,
            'atividade_id' => $atividadeId,
            'data_inscricao' => new \DateTime(),
            'user_id' => $this->request->getAttribute('identity')->id ?? null
        ]);

        if ($this->fetchTable('Inscricoes')->save($inscricao)) {
            $this->Flash->success('Inscrição realizada com sucesso!');
        } else {
            $this->Flash->error('Não foi possível completar a inscrição.');
        }

        return $this->redirect([
            'controller' => 'Atividades',
            'action' => 'view',
            $atividadeId
        ]);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Inscricoes->find()
            ->contain(['Alunos', 'Atividades', 'Users', 'Responsavels']);
        $inscricoes = $this->paginate($query);

        $this->set(compact('inscricoes'));
    }

    /**
     * View method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inscrico = $this->Inscricoes->get($id, contain: ['Alunos', 'Atividades', 'Users', 'Responsavels']);
        $this->set(compact('inscrico'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscrico = $this->Inscricoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $inscrico = $this->Inscricoes->patchEntity($inscrico, $this->request->getData());
            if ($this->Inscricoes->save($inscrico)) {
                $this->Flash->success(__('The inscrico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscrico could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', limit: 200)->all();
        $atividades = $this->Inscricoes->Atividades->find('list', limit: 200)->all();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscrico', 'alunos', 'atividades', 'users', 'responsavels'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inscrico = $this->Inscricoes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscrico = $this->Inscricoes->patchEntity($inscrico, $this->request->getData());
            if ($this->Inscricoes->save($inscrico)) {
                $this->Flash->success(__('The inscrico has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inscrico could not be saved. Please, try again.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', limit: 200)->all();
        $atividades = $this->Inscricoes->Atividades->find('list', limit: 200)->all();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscrico', 'alunos', 'atividades', 'users', 'responsavels'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inscrico id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inscrico = $this->Inscricoes->get($id);
        if ($this->Inscricoes->delete($inscrico)) {
            $this->Flash->success(__('The inscrico has been deleted.'));
        } else {
            $this->Flash->error(__('The inscrico could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
