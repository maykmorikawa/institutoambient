<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\TableRegistry;

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
    public function view($slug = null)
    {
        $this->viewBuilder()->setLayout('site');
        if (!$slug) {
            throw new NotFoundException(__('Post não encontrado.'));
        }

        $slug = urldecode($slug);
        $postsTable = $this->fetchTable('Posts');

        $post = $postsTable->find()
            ->where(['slug' => $slug])
            ->contain(['Tags']) // ← isso traz as tags relacionadas
            ->first();

        if (!$post) {
            throw new NotFoundException(__('Post não encontrado.'));
        }

        // Buscar os 3 posts recentes, exceto o atual
        $recentes = $postsTable->find()
            ->where([
                'status' => 'publicado',
                'id !=' => $post->id // Evita repetir o post atual
            ])
            ->order(['published' => 'DESC'])
            ->limit(3)
            ->all();

        
        $this->set(compact('post', 'recentes'));
    }

    public function tag($slug = null)
    {
        $this->viewBuilder()->setLayout('site');
        if (!$slug) {
            throw new NotFoundException('Slug de tag não fornecido.');
        }

        $tagsTable = $this->fetchTable('Tags');
        $tag = $tagsTable->findBySlug($slug)->contain(['Posts'])->first();

        if (!$tag) {
            throw new NotFoundException('Tag não encontrada.');
        }

        $posts = $tag->posts;

        $recentes = $this->Posts->find()
            ->where(['status' => 'publicado'])
            ->order(['created' => 'DESC'])
            ->limit(3)
            ->all();

        $tags = $tagsTable->find()->all();
                        
        $this->set(compact('posts', 'recentes', 'tags'));
        
    }





    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $post = $this->Posts->newEmptyEntity();
        if ($this->request->is('post')) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
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
    public function edit($id = null)
    {
        $post = $this->Posts->get($id, contain: ['Tags']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $post = $this->Posts->patchEntity($post, $this->request->getData());
            if ($this->Posts->save($post)) {
                $this->Flash->success(__('The post has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post could not be saved. Please, try again.'));
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
