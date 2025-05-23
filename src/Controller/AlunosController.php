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

    public function beforeFilter(EventInterface $event): void
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
        $aluno = $this->Alunos->newEmptyEntity();

        // Recupera atividade_id da URL ou sessão
        $atividade_id = $this->request->getQuery('atividade_id')
            ?? $this->request->getSession()->read('Inscricao.atividade_id');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['atividade_id'] = $atividade_id; // Garante o vínculo

            $aluno = $this->Alunos->patchEntity($aluno, $data);

            if ($this->Alunos->save($aluno)) {
                // Força o redirecionamento ignorando qualquer hook
                $response = $this->redirect([
                    'controller' => 'Inscricoes',
                    'action' => 'processarInscricao',
                    '?' => [
                        'atividade_id' => $atividade_id,
                        'aluno_id' => $aluno->id
                    ]
                ]);
                return $response->withDisabledCache(); // Opcional
            }
        }

        // Passa atividade_id para o template
        $users = $this->Alunos->Users->find('list', limit: 200)->all();
        $this->set(compact('aluno', 'users', 'atividade_id'));
        $this->viewBuilder()->setLayout('site');
    }
}
