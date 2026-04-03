<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\I18n\FrozenDate;

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

    public function beforeFilter(EventInterface $event): void: void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['verificar', 'processarInscricao', 'confirmacao', 'comprovante']);
    }

    /**
     * Ação para verificação de cadastro
     */
    public function verificar($slug = null)
    {
        $atividade = $this->fetchTable('Atividades')
            ->findBySlug($slug)
            ->firstOrFail();

        if ($this->request->is('post')) {
            $cpf = preg_replace('/[^0-9]/', '', $this->request->getData('cpf'));
            $dataNascimento = new FrozenDate($this->request->getData('data_nascimento'));

            // Cálculo da idade
            $hoje = FrozenDate::today();
            $idade = $hoje->diff($dataNascimento)->y;

            // Verifica faixa etária da atividade
            if (
                (!is_null($atividade->idade_minima) && $idade < $atividade->idade_minima) ||
                (!is_null($atividade->idade_maxima) && $idade > $atividade->idade_maxima)
            ) {
                $this->Flash->error("Esta atividade é permitida apenas para pessoas entre {$atividade->idade_minima} e {$atividade->idade_maxima} anos.");
                return $this->redirect($this->referer());
            }

            // Busca aluno
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
                    '?' => [
                        'atividade_id' => $atividade->id,
                        'aluno_id' => $aluno->id
                    ]
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
        $this->viewBuilder()->setLayout('print');
        $atividadeId = $this->request->getQuery('atividade_id');
        $alunoId = $this->request->getQuery('aluno_id');

        // ✅ Validação logo no começo
        if (empty($atividadeId) || empty($alunoId)) {
            $this->Flash->error('Parâmetros inválidos para inscrição.');
            return $this->redirect(['controller' => 'Atividades', 'action' => 'index']);
        }

        // Verifica se já está inscrito
        $inscricaoExistente = $this->fetchTable('Inscricoes')
            ->find()
            ->where([
                'aluno_id' => $alunoId,
                'atividade_id' => $atividadeId
            ])
            ->first();

        if ($inscricaoExistente) {
            $this->Flash->warning(__('Você já está inscrito nesta atividade.'));
            return $this->redirectToInscricaoSuccess($atividadeId, $alunoId);
        }

        // Cria nova inscrição
        $inscricao = $this->Inscricoes->newEntity([
            'aluno_id' => $alunoId,
            'atividade_id' => $atividadeId,
            'data_inscricao' => new \DateTime(),
            'user_id' => $this->request->getAttribute('identity')->id ?? null
        ]);

        if ($this->Inscricoes->save($inscricao)) {
            return $this->redirectToInscricaoSuccess($atividadeId, $alunoId);
        } else {
            $this->Flash->error(__('Erro ao processar inscrição.'));
            return $this->redirect(['controller' => 'Atividades', 'action' => 'index']);
        }

    }


    // Novo método privado para centralizar o redirecionamento
    private function redirectToInscricaoSuccess($atividadeId, $alunoId)
    {
        // Armazena dados na sessão
        $this->request->getSession()->write('Inscricao.success', [
            'atividade_id' => $atividadeId,
            'aluno_id' => $alunoId
        ]);

        // Redireciona para página de confirmação
        return $this->redirect([
            'action' => 'confirmacao'
        ]);
    }

    public function confirmacao()
    {
        $dados = $this->request->getSession()->consume('Inscricao.success');

        if (empty($dados)) {
            $this->Flash->error('Dados de confirmação não encontrados.');
            return $this->redirect(['controller' => 'Atividades', 'action' => 'index']);
        }

        // ✅ Corrigido: named argument
        $atividade = $this->fetchTable('Atividades')->get(
            $dados['atividade_id'],
            contain: []
        );

        $aluno = $this->fetchTable('Alunos')->get($dados['aluno_id']);

        $inscricao = $this->fetchTable('Inscricoes')->find()
            ->where([
                'Inscricoes.atividade_id' => $dados['atividade_id'],
                'Inscricoes.aluno_id' => $dados['aluno_id']
            ])
            ->contain(['Alunos', 'Atividades'])
            ->first();

        if (!$atividade || !$aluno || !$inscricao) {
            $this->Flash->error('Inscrição não encontrada.');
            return $this->redirect(['controller' => 'Atividades', 'action' => 'index']);
        }

        $this->set(compact('atividade', 'aluno', 'inscricao'));
        $this->viewBuilder()->setLayout('print');
    }

    public function comprovante($id = null)
    {
        if (!$id) {
            $this->Flash->error('ID de inscrição inválido.');
            return $this->redirect(['action' => 'index']);
        }

        $inscricao = $this->Inscricoes->find()
            ->where(['Inscricoes.id' => $id])
            ->contain(['Alunos', 'Atividades'])
            ->first();

        if (!$inscricao) {
            $this->Flash->error('Inscrição não encontrada.');
            return $this->redirect(['action' => 'index']);
        }

        $aluno = $inscricao->aluno;
        $atividade = $inscricao->atividade;

        $this->set(compact('inscricao', 'aluno', 'atividade'));

        // Caso queira layout especial para impressão:
        if ($this->request->getQuery('print') === '1') {
            $this->viewBuilder()->setLayout('print'); // Crie esse layout se quiser um visual próprio
        } else {
            $this->viewBuilder()->setLayout('site');
        }

        $this->render('comprovante'); // Renderiza templates/Inscricoes/comprovante.php
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
        $inscricao = $this->Inscricoes->get($id, contain: ['Alunos', 'Atividades', 'Users', 'Responsavels']);
        $this->set(compact('inscricao'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inscricao = $this->Inscricoes->newEmptyEntity();
        if ($this->request->is('post')) {
            $inscricao = $this->Inscricoes->patchEntity($inscricao, $this->request->getData());
            if ($this->Inscricoes->save($inscricao)) {
                $this->Flash->success(__('A inscrição foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A inscrição não pôde ser salva. Por favor, tente novamente.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', limit: 200)->all();
        $atividades = $this->Inscricoes->Atividades->find('list', limit: 200)->all();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscricao', 'alunos', 'atividades', 'users', 'responsavels'));
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
        $inscricao = $this->Inscricoes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inscricao = $this->Inscricoes->patchEntity($inscricao, $this->request->getData());
            if ($this->Inscricoes->save($inscricao)) {
                $this->Flash->success(__('A inscrição foi salva com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('A inscrição não pôde ser salva. Por favor, tente novamente.'));
        }
        $alunos = $this->Inscricoes->Alunos->find('list', limit: 200)->all();
        $atividades = $this->Inscricoes->Atividades->find('list', limit: 200)->all();
        $users = $this->Inscricoes->Users->find('list', limit: 200)->all();
        $responsavels = $this->Inscricoes->Responsavels->find('list', limit: 200)->all();
        $this->set(compact('inscricao', 'alunos', 'atividades', 'users', 'responsavels'));
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
        if ($this->Inscricoes->delete($inscricao)) {
            $this->Flash->success(__('A inscrição foi deletada com sucesso.'));
        } else {
            $this->Flash->error(__('A inscrição não pôde ser deletada. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
