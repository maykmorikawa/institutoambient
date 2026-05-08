<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 */
class DocumentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Documents->find()
            ->orderBy(['created' => 'DESC']);
        $documents = $this->paginate($query);

        $this->set(compact('documents'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Documents->newEmptyEntity();
        if ($this->request->is('post')) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            
            // Handle file upload
            $file = $this->request->getData('pdf_file');
            if ($file && $file->getError() === 0) {
                $targetPath = WWW_ROOT . 'uploads' . DS . 'pdfs' . DS;
                if (!is_dir($targetPath)) {
                    mkdir($targetPath, 0775, true);
                }

                $filename = time() . '-' . $file->getClientFilename();
                $file->moveTo($targetPath . $filename);
                $document->filename = $filename;
            }

            if ($this->Documents->save($document)) {
                $this->Flash->success(__('O documento foi salvo com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O documento não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('document'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            
            // Handle file upload
            $file = $this->request->getData('pdf_file');
            if ($file && $file->getError() === 0) {
                $targetPath = WWW_ROOT . 'uploads' . DS . 'pdfs' . DS;
                
                // Delete old file if exists
                if ($document->filename) {
                    $oldFile = $targetPath . $document->filename;
                    if (file_exists($oldFile)) {
                        @unlink($oldFile);
                    }
                }
                
                $filename = time() . '-' . $file->getClientFilename();
                $file->moveTo($targetPath . $filename);
                $document->filename = $filename;
            }

            if ($this->Documents->save($document)) {
                $this->Flash->success(__('O documento foi atualizado com sucesso.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('O documento não pôde ser salvo. Por favor, tente novamente.'));
        }
        $this->set(compact('document'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        
        // Delete file if exists
        if ($document->filename) {
            $file = WWW_ROOT . 'uploads' . DS . 'pdfs' . DS . $document->filename;
            if (file_exists($file)) {
                @unlink($file);
            }
        }

        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('O documento foi excluído com sucesso.'));
        } else {
            $this->Flash->error(__('O documento não pôde ser excluído. Por favor, tente novamente.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
