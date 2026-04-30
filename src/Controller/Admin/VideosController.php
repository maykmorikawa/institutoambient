<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;

/**
 * Videos Controller
 *
 * @property \App\Model\Table\VideosTable $Videos
 */
class VideosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Videos->find()
            ->orderBy(['created' => 'DESC']);
        $videos = $this->paginate($query);

        $this->set(compact('videos'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $video = $this->Videos->newEmptyEntity();
        if ($this->request->is('post')) {
            $video = $this->Videos->patchEntity($video, $this->request->getData());
            
            // Handle file upload
            $image = $this->request->getData('background_image_file');
            if ($image && $image->getError() === 0) {
                $filename = time() . '-' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                $video->background_image = $filename;
            }

            if ($this->Videos->save($video)) {
                $this->Flash->success(__('O vídeo foi salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O vídeo não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('video'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Video id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $video = $this->Videos->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $video = $this->Videos->patchEntity($video, $this->request->getData());
            
            // Handle file upload
            $image = $this->request->getData('background_image_file');
            if ($image && $image->getError() === 0) {
                // Delete old image if exists
                if ($video->background_image) {
                    $oldFile = WWW_ROOT . 'img/uploads/' . $video->background_image;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                $filename = time() . '-' . $image->getClientFilename();
                $image->moveTo(WWW_ROOT . 'img/uploads/' . $filename);
                $video->background_image = $filename;
            }

            if ($this->Videos->save($video)) {
                $this->Flash->success(__('O vídeo foi atualizado com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O vídeo não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('video'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Video id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $video = $this->Videos->get($id);
        
        // Delete image file if exists
        if ($video->background_image) {
            $file = WWW_ROOT . 'img/uploads/' . $video->background_image;
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        if ($this->Videos->delete($video)) {
            $this->Flash->success(__('O vídeo foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O vídeo não pôde ser excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
