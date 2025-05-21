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
       
        $post = $this->Posts->get($id, contain: ['Categories', 'Users', 'Tags', 'Comments', 'PostImages']);

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
            if ($this->Posts->save($post)) {
                // Gerenciar múltiplos uploads de imagem
                $images = $this->request->getData('images');
                if (!empty($images) && is_array($images)) {
                    $isFirst = true; // Flag para primeira imagem

                    foreach ($images as $image) {
                        if ($image && $image->getError() === 0) {
                            $filename = time() . '-' . $image->getClientFilename();
                            $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);

                            $postImage = $this->Posts->PostImages->newEmptyEntity();
                            $postImage->post_id = $post->id;
                            $postImage->filename = $filename;
                            $postImage->is_featured = $isFirst; // Define como destaque a primeira imagem

                            $this->Posts->PostImages->save($postImage);
                            $isFirst = false; // Depois da primeira, não marca mais
                        }
                    }
                }

                $this->Flash->success(__('Post salvo com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }


            $this->Flash->error(__('Não foi possível salvar o post.'));
        }

        $categoryTree = $this->Posts->Categories->find('treeList', keyPath: 'id', valuePath: 'name', spacer: '— ')->toArray();
        $categories = $this->Posts->Categories->find('list', limit: 200)->all();
        $users = $this->Posts->Users->find('list', limit: 200)->all();
        $tags = $this->Posts->Tags->find('list', limit: 200)->all();

        $this->set(compact('post', 'categories', 'users', 'tags', 'categoryTree'));
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

        $post = $this->Posts->get($id, contain: ['Categories', 'Users', 'Tags', 'PostImages']);


        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            // Atualizar slug se o título mudou
            if ($post->title !== $data['title']) {
                $data['slug'] = Text::slug($data['title']);
            }

            $post = $this->Posts->patchEntity($post, $data, ['associated' => ['Tags']]);

            if ($this->Posts->save($post)) {

                // Atualizar imagem de destaque
                $featuredImageId = $this->request->getData('featured_image_id');
                if ($featuredImageId) {
                    $this->Posts->PostImages->updateAll(['is_featured' => false], ['post_id' => $post->id]);
                    $this->Posts->PostImages->updateAll(['is_featured' => true], ['id' => $featuredImageId]);
                }


                

                // 🔥 EXCLUIR imagens marcadas
                $toDelete = $this->request->getData('delete_images');
                if (!empty($toDelete)) {
                    foreach ($toDelete as $imageId => $value) {
                        if ($value == '1') {
                            $image = $this->Posts->PostImages->get($imageId);
                            $filePath = WWW_ROOT . 'img/uploads/' . $image->filename;

                            if (file_exists($filePath)) {
                                unlink($filePath);
                            }

                            $this->Posts->PostImages->delete($image);
                        }
                    }
                }

                // ⚡ ADICIONAR novas imagens
                $images = $this->request->getData('images');
                if (!empty($images) && is_array($images)) {
                    // Se ainda existir alguma imagem, nenhuma nova será destaque
                    $hasFeatured = $this->Posts->PostImages
                        ->find()
                        ->where(['post_id' => $post->id, 'is_featured' => true])
                        ->count() > 0;

                    foreach ($images as $image) {
                        if ($image && $image->getError() === 0) {
                            $filename = time() . '-' . $image->getClientFilename();
                            $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);

                            $postImage = $this->Posts->PostImages->newEmptyEntity();
                            $postImage->post_id = $post->id;
                            $postImage->filename = $filename;
                            $postImage->is_featured = !$hasFeatured; // A primeira vira destaque se nenhuma outra for

                            $this->Posts->PostImages->save($postImage);
                            $hasFeatured = true;
                        }
                    }
                }

                $this->Flash->success(__('Post atualizado com sucesso.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Não foi possível salvar o post.'));
        }

        $categoryTree = $this->Posts->Categories->find('treeList', keyPath: 'id', valuePath: 'name', spacer: '— ')->toArray();
        $categories = $this->Posts->Categories->find('list')->all();
        $users = $this->Posts->Users->find('list')->all();
        $tags = $this->Posts->Tags->find('list')->all();

        $this->set(compact('post', 'categories', 'users', 'tags', 'categoryTree'));
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
