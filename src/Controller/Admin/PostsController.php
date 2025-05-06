<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Utility\Text; // Esta linha é crucial
use Cake\Http\Exception\NotFoundException;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Posts->find()
            ->contain(['Categories', 'Users']);
        $posts = $this->paginate($query);

        $this->set(compact('posts'));
    }

    /**
     * View method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $post = $this->Posts->get($id, contain: ['Categories', 'Users', 'Tags', 'Comments']);
        $this->set(compact('post'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity(); // Certifique-se que $post está definido

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Gerar o slug a partir do título
            $slug = Text::slug($data['title']);
            $data['slug'] = $slug;

            $post = $this->Posts->patchEntity($post, $data);

            // Gerenciar o upload da imagem
            $image = $this->request->getData('image');
            if (!empty($image) && is_object($image) && !$image->getError()) {
                $filename = time() . '-' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                $post->image = 'uploads/' . $filename;
            } elseif (!empty($image) && is_object($image) && $image->getError()) {
                $this->Flash->error(__('Erro ao fazer o upload da imagem.'));
            }

            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Post salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Não foi possível salvar o post.'));
        }

        $categories = $this->Posts->Categories->find('list', limit: 200)->all();
        $users = $this->Posts->Users->find('list', limit: 200)->all();
        $tags = $this->Posts->Tags->find('list', limit: 200)->all();

        $this->set(compact('post', 'categories', 'users', 'tags'));
    }


    /**
     * Edit method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?int $id = null)
    {
        if ($id === null) {
            throw new NotFoundException(__('Post não encontrado.'));
        }

        $post = $this->Posts->get($id, contain: ['Categories', 'Users', 'Tags']);

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            // Separar o objeto da imagem e remover do array para evitar erro
            $image = $data['image'] ?? null;
            unset($data['image']);

            // Gerar slug se o título mudou
            if ($post->title !== $data['title']) {
                $data['slug'] = Text::slug($data['title']);
            }

            // Salvar a imagem atual
            $imagemAtual = $post->image;

            // Aplicar os dados na entidade (sem o campo de imagem)
            $post = $this->Posts->patchEntity($post, $data);

            // Verificar se nova imagem foi enviada
            if (!empty($image) && is_object($image) && !$image->getError()) {
                // Excluir imagem antiga, se existir
                if (!empty($imagemAtual) && file_exists(WWW_ROOT . $imagemAtual)) {
                    unlink(WWW_ROOT . $imagemAtual);
                }

                $filename = time() . '-' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                $post->image = 'uploads/' . $filename;
            } else {
                // Manter imagem atual se nenhuma nova foi enviada
                $post->image = $imagemAtual;
            }

            if ($this->Posts->save($post)) {
                $this->Flash->success(__('Post atualizado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Não foi possível salvar o post.'));
        }

        $categories = $this->Posts->Categories->find('list', limit: 200)->all();
        $users = $this->Posts->Users->find('list', limit: 200)->all();
        $tags = $this->Posts->Tags->find('list', limit: 200)->all();

        $this->set(compact('post', 'categories', 'users', 'tags'));
    }


    /**
     * Delete method
     *
     * @param string|null $id Post id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $post = $this->Posts->get($id);
        if ($this->Posts->delete($post)) {
            $this->Flash->success(__('The post has been deleted.'));
        } else {
            $this->Flash->error(__('The post could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
