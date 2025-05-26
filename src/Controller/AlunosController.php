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
        $atividade_id = $this->request->getQuery('atividade_id');
        $aluno_id = $this->request->getQuery('aluno_id');

        if ($aluno_id) {
            // Carrega aluno existente com relações
            $aluno = $this->Alunos->get($aluno_id, ['contain' => ['Enderecos', 'Escolaridades']]);
        } else {
            $aluno = $this->Alunos->newEmptyEntity();
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['atividade_id'] = $atividade_id;

            $aluno = $this->Alunos->patchEntity($aluno, $data, [
                'associated' => ['Enderecos', 'Escolaridades']
            ]);

            if ($this->Alunos->save($aluno)) {
                // 1ª Etapa: salvar aluno e ir para endereço
                if (!$aluno_id) {
                    return $this->redirect([
                        'action' => 'add',
                        '?' => [
                            'atividade_id' => $atividade_id,
                            'aluno_id' => $aluno->id
                        ]
                    ]);
                }

                // 2ª Etapa: salvar endereço, ir para escolaridade
                if (!isset($data['escolaridades'])) {
                    $this->Flash->success('Endereço salvo. Agora preencha a escolaridade.');
                    return $this->redirect($this->request->getRequestTarget());
                }

                // 3ª Etapa: tudo salvo, vai para próxima etapa (ex: inscrição)
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
        $atividades = []; // Carregue as atividades aqui se necessário
        $this->set(compact('aluno', 'users', 'atividade_id', 'aluno_id', 'atividades'));
        $this->viewBuilder()->setLayout('site');
    }
}
