<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/5/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    public function view($slug = null)
    {
        if (!$slug) {
            throw new NotFoundException(__('Post não encontrado.'));
        }

        $slug = urldecode($slug);
        $slug = mb_strtolower($slug);

        $postsTable = $this->fetchTable('Posts');

        $post = $postsTable->find()
            ->where(['LOWER(slug)' => $slug])
            ->first();

        if (!$post) {
            throw new NotFoundException(__('Post não encontrado.'));
        }

        $this->set(compact('post'));
        $this->viewBuilder()->setLayout('site');
    }
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = $subpage = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        $this->set(compact('page', 'subpage'));

        $this->viewBuilder()->setLayout('site');

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }




    public function manutencao()
    {
        $this->viewBuilder()->setLayout('manutencao');
        $this->render('manutencao'); // Garante que a view correta será carregada
    }
    public function quemsomos() {}

    public function transparencia() {}
    public function videos() {}
    public function conselho() {}



    public function home()
    {
        $categoriesTable = TableRegistry::getTableLocator()->get('Categories');
        $postsTable = TableRegistry::getTableLocator()->get('Posts');

        // =============================
        // Seção 2: Editais + Projetos
        // =============================
        $editaisCategory = $categoriesTable->find()
            ->where(['slug' => 'editais'])
            ->first();

        $postsEditais = [];
        if ($editaisCategory && $editaisCategory->lft !== null && $editaisCategory->rght !== null) {
            $editaisSubcategoryIds = collection(
                $categoriesTable->find()
                    ->where([
                        'lft >=' => $editaisCategory->lft,
                        'rght <=' => $editaisCategory->rght
                    ])
                    ->all()
            )->extract('id')->toList();

            $postsEditais = $postsTable->find()
                ->where([
                    'status' => 'publicado',
                    'category_id IN' => $editaisSubcategoryIds
                ])
                ->order(['created' => 'DESC'])
                ->limit(4)
                ->all();
        }

        // =============================
        // Seção 1: Notícias + Blog
        // =============================
        $noticiasCategory = $categoriesTable->find()
            ->where(['slug' => 'noticias'])
            ->first();

        $postsNoticias = [];
        if ($noticiasCategory && $noticiasCategory->lft !== null && $noticiasCategory->rght !== null) {
            $noticiasSubcategoryIds = collection(
                $categoriesTable->find()
                    ->where([
                        'lft >=' => $noticiasCategory->lft,
                        'rght <=' => $noticiasCategory->rght
                    ])
                    ->all()
            )->extract('id')->toList();

            $postsNoticias = $postsTable->find()
                ->where([
                    'status' => 'publicado',
                    'category_id IN' => $noticiasSubcategoryIds
                ])
                ->order(['created' => 'DESC'])
                ->limit(3)
                ->all();
        }

        // Enviar para a view
        $this->set(compact('postsNoticias', 'postsEditais'));
        $this->viewBuilder()->setLayout('site');
    }
}
