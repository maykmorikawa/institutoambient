<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PostsTags Controller
 *
 * @property \App\Model\Table\PostsTagsTable $PostsTags
 */
class PostsTagsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PostsTags->find()
            ->contain(['Posts', 'Tags']);
        $postsTags = $this->paginate($query);

        $this->set(compact('postsTags'));
    }

    /**
     * View method
     *
     * @param string|null $id Posts Tag id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $postsTag = $this->PostsTags->get($id, contain: ['Posts', 'Tags']);
        $this->set(compact('postsTag'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $postsTag = $this->PostsTags->newEmptyEntity();
        if ($this->request->is('post')) {
            $postsTag = $this->PostsTags->patchEntity($postsTag, $this->request->getData());
            if ($this->PostsTags->save($postsTag)) {
                $this->Flash->success(__('The posts tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The posts tag could not be saved. Please, try again.'));
        }
        $posts = $this->PostsTags->Posts->find('list', limit: 200)->all();
        $tags = $this->PostsTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('postsTag', 'posts', 'tags'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Posts Tag id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $postsTag = $this->PostsTags->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $postsTag = $this->PostsTags->patchEntity($postsTag, $this->request->getData());
            if ($this->PostsTags->save($postsTag)) {
                $this->Flash->success(__('The posts tag has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The posts tag could not be saved. Please, try again.'));
        }
        $posts = $this->PostsTags->Posts->find('list', limit: 200)->all();
        $tags = $this->PostsTags->Tags->find('list', limit: 200)->all();
        $this->set(compact('postsTag', 'posts', 'tags'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Posts Tag id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $postsTag = $this->PostsTags->get($id);
        if ($this->PostsTags->delete($postsTag)) {
            $this->Flash->success(__('The posts tag has been deleted.'));
        } else {
            $this->Flash->error(__('The posts tag could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
