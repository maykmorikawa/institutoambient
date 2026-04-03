<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

/**
 * Alunos Controller
 *
 * @property \App\Model\Table\AlunosTable $Alunos
 */
class AlunosController extends AppController
{

    public function beforeFilter(EventInterface $event): void: void
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['add']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $atividade_id = $this->request->getQuery('atividade_id');

        $aluno = $this->Alunos->newEmptyEntity([
            'associated' => ['Enderecos', 'Escolaridades']
        ]);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['atividade_id'] = $atividade_id;

            $aluno = $this->Alunos->patchEntity($aluno, $data, [
                'associated' => ['Enderecos', 'Escolaridades']
            ]);

            if ($this->Alunos->save($aluno)) {
                $this->Flash->success('Aluno cadastrado com sucesso.');
                return $this->redirect([
                    'controller' => 'Inscricoes',
                    'action' => 'processarInscricao',
                    '?' => [
                        'atividade_id' => $atividade_id,
                        'aluno_id' => $aluno->id
                    ]
                ]);
            }

            $this->Flash->error('Erro ao salvar os dados. Verifique os campos.');
        }

        $users = $this->Alunos->Users->find('list')->all();
        $atividades = []; // Carregue as atividades se necessário
        $this->set(compact('aluno', 'users', 'atividade_id', 'atividades'));
        $this->viewBuilder()->setLayout('site');
    }
}
