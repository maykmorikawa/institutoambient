<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PostImages Controller
 *
 * @property \App\Model\Table\PostImagesTable $PostImages
 */
class PostImagesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PostImages->find()
            ->contain(['Posts']);
        $postImages = $this->paginate($query);

        $this->set(compact('postImages'));
    }

    /**
     * View method
     *
     * @param string|null $id Post Image id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postImage = $this->PostImages->get($id, contain: ['Posts']);
        $this->set(compact('postImage'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postImage = $this->PostImages->newEmptyEntity();
        if ($this->request->is('post')) {
            $postImage = $this->PostImages->patchEntity($postImage, $this->request->getData());
            if ($this->PostImages->save($postImage)) {
                $this->Flash->success(__('The post image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post image could not be saved. Please, try again.'));
        }
        $posts = $this->PostImages->Posts->find('list', limit: 200)->all();
        $this->set(compact('postImage', 'posts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Post Image id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postImage = $this->PostImages->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postImage = $this->PostImages->patchEntity($postImage, $this->request->getData());
            if ($this->PostImages->save($postImage)) {
                $this->Flash->success(__('The post image has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The post image could not be saved. Please, try again.'));
        }
        $posts = $this->PostImages->Posts->find('list', limit: 200)->all();
        $this->set(compact('postImage', 'posts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Post Image id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postImage = $this->PostImages->get($id);
        if ($this->PostImages->delete($postImage)) {
            $this->Flash->success(__('The post image has been deleted.'));
        } else {
            $this->Flash->error(__('The post image could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
