<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\I18n\FrozenDate; // Certifique-se de que está importado
use Cake\Http\Exception\NotFoundException; // Importar para exceções de record not found
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Exception\RecordNotFoundException;

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

    public function marcar($aulaId = null)
    {
        try {
            $aula = $this->Aulas->get($aulaId, [
                'contain' => [
                    'Atividades', // Para mostrar o nome da atividade
                    'Presencas.Alunos', // Carrega presenças existentes e os alunos associados
                ],
            ]);
        } catch (RecordNotFoundException $e) {
            $this->Flash->error(__('Aula não encontrada.'));
            return $this->redirect($this->referer() ?: ['controller' => 'Atividades', 'action' => 'index']);
        }

        // Obtém todos os alunos com status 'confirmada' para a atividade desta aula
        $alunosInscritosConfirmados = $this->Inscricoes->find()
            ->contain(['Alunos']) // Carrega a entidade Aluno para cada Inscrição
            ->where([
                'Inscricoes.atividade_id' => $aula->atividade->id,
                'Inscricoes.status' => 'confirmada'
            ])
            ->order(['Alunos.nome_completo' => 'ASC']) // Opcional: ordenar por nome do aluno
            ->toArray(); // Converte para array de entidades

        // Mapeia as presenças existentes para fácil acesso (aluno_id => entidade Presenca)
        $presencasExistentes = [];
        foreach ($aula->presencas as $presenca) {
            $presencasExistentes[$presenca->aluno_id] = $presenca;
        }

        // Lida com o envio do formulário (POST)
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $presencasParaSalvar = [];

            foreach ($alunosInscritosConfirmados as $inscricao) {
                $alunoId = $inscricao->aluno->id;
                $isPresent = isset($data['presenca'][$alunoId]) && $data['presenca'][$alunoId] === '1';

                // Verifica se já existe uma presença para este aluno e aula
                if (isset($presencasExistentes[$alunoId])) {
                    $presenca = $presencasExistentes[$alunoId];
                    if ($presenca->presente != (int) $isPresent) { // Se o status mudou, atualiza
                        $presenca->presente = (int) $isPresent;
                        $presencasParaSalvar[] = $presenca;
                    }
                } else {
                    // Se não existe, cria uma nova entidade Presenca apenas se estiver presente (ou se quiser criar mesmo ausente)
                    $presenca = $this->Presencas->newEmptyEntity();
                    $presenca->aula_id = $aulaId;
                    $presenca->aluno_id = $alunoId;
                    $presenca->presente = (int) $isPresent;
                    $presencasParaSalvar[] = $presenca;
                }
            }

            $connection = ConnectionManager::get('default');
            try {
                $connection->transactional(function () use ($presencasParaSalvar) {
                    if (!$this->Presencas->saveMany($presencasParaSalvar)) {
                        throw new \Exception(__('Erro ao salvar algumas presenças.'));
                    }
                });
                $this->Flash->success(__('Frequência marcada com sucesso.'));
                // Redireciona de volta para a view da atividade
                return $this->redirect(['controller' => 'Atividades', 'action' => 'view', $aula->atividade->id]);
            } catch (\Exception $e) {
                $this->Flash->error(__('Não foi possível marcar a frequência: ' . $e->getMessage()));
            }
        }

        $this->set(compact('aula', 'alunosInscritosConfirmados', 'presencasExistentes'));
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
