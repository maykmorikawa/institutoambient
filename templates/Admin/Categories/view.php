<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-folder me-2 text-primary"></i><?= __('Detalhes da Categoria') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-list fa-sm text-white-50 me-1"></i> Lista de Categorias', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Editar', ['action' => 'edit', $category->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50 me-1"></i> Nova Categoria', ['action' => 'add'], ['class' => 'btn btn-sm btn-success', 'escape' => false]) ?>
    </div>
</div>

<div class="row">
    <!-- Informações da Categoria -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100 border-left-success">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-success"><?= __('Informações Básicas') ?></h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-4 text-success mb-2">
                        <i class="fas fa-folder-open"></i>
                    </div>
                    <h2 class="h4 font-weight-bold text-dark mb-0"><?= h($category->name) ?></h2>
                    <span class="badge badge-light border px-3 py-2 mt-2">
                        <code><?= h($category->slug) ?></code>
                    </span>
                </div>
                
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-fingerprint me-2"></i>ID</span>
                        <span class="font-weight-bold text-dark">#<?= $this->Number->format($category->id) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-level-up-alt me-2"></i>Cat. Pai</span>
                        <span><?= $category->hasValue('parent_category') ? $this->Html->link($category->parent_category->name, ['action' => 'view', $category->parent_category->id], ['class' => 'font-weight-bold text-primary']) : '<span class="text-muted">-</span>' ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-calendar-plus me-2"></i>Criado em</span>
                        <span class="text-dark"><?= h($category->created->format('d/m/Y H:i')) ?></span>
                    </li>
                    <li class="list-group-item px-0 mt-3 border-0">
                        <span class="text-muted d-block mb-1"><i class="fas fa-align-left me-2"></i>Descrição</span>
                        <div class="p-3 bg-light rounded text-dark small border">
                            <?= !empty($category->description) ? $this->Text->autoParagraph(h($category->description)) : '<span class="text-muted fst-italic">Nenhuma descrição informada.</span>' ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        
        <!-- Subcategorias -->
        <?php if (!empty($category->child_categories)) : ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Subcategorias (' . count($category->child_categories) . ')') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-0">
                        <thead class="bg-light text-dark small text-uppercase">
                            <tr>
                                <th class="border-0 px-4"><?= __('Nome / Slug') ?></th>
                                <th class="border-0"><?= __('Criado em') ?></th>
                                <th class="border-0 text-center px-4"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category->child_categories as $child) : ?>
                            <tr>
                                <td class="px-4">
                                    <div class="font-weight-bold text-dark d-flex align-items-center">
                                        <i class="fas fa-folder text-muted me-2"></i><?= h($child->name) ?>
                                    </div>
                                    <code class="small bg-light px-1 rounded text-primary mt-1 d-inline-block"><?= h($child->slug) ?></code>
                                </td>
                                <td class="small">
                                    <?= h($child->created->format('d/m/Y')) ?>
                                </td>
                                <td class="text-center px-4">
                                    <div class="btn-group">
                                        <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['action' => 'view', $child->id], ['class' => 'btn btn-sm btn-light border', 'title' => 'Ver Subcategoria', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $child->id], ['class' => 'btn btn-sm btn-light border', 'title' => 'Editar', 'escape' => false]) ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Postagens na Categoria -->
        <div class="card shadow">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Postagens nesta Categoria') . (!empty($category->posts) ? ' (' . count($category->posts) . ')' : '') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <?php if (!empty($category->posts)) : ?>
                    <table class="table table-hover align-middle mb-0 border-0">
                        <thead class="bg-light text-dark small text-uppercase">
                            <tr>
                                <th class="border-0 px-4"><?= __('Título') ?></th>
                                <th class="border-0 text-center"><?= __('Status') ?></th>
                                <th class="border-0"><?= __('Publicado em') ?></th>
                                <th class="border-0 text-center px-4"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category->posts as $post) : ?>
                                <tr>
                                    <td class="px-4">
                                        <div class="font-weight-bold text-dark"><?= h($post->title) ?></div>
                                        <small class="text-muted">ID: #<?= h($post->id) ?></small>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($post->status === 'publicado'): ?>
                                            <span class="badge badge-success shadow-sm px-2"><i class="fas fa-check-circle me-1 small"></i>Ativo</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning shadow-sm px-2"><i class="fas fa-clock me-1 small"></i>Rascunho</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small">
                                        <?= $post->published ? h($post->published->format('d/m/Y')) : '<span class="text-muted small">Não agendado</span>' ?>
                                    </td>
                                    <td class="text-center px-4">
                                        <div class="btn-group">
                                            <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['controller' => 'Posts', 'action' => 'view', $post->id], ['class' => 'btn btn-sm btn-light border', 'title' => 'Ver Post', 'escape' => false]) ?>
                                            <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-light border', 'title' => 'Editar Post', 'escape' => false]) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else : ?>
                        <div class="text-center py-5">
                            <div class="mb-3"><i class="fas fa-file-alt fa-3x text-gray-300"></i></div>
                            <h5 class="text-muted">Nenhuma postagem associada.</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .badge-success { background-color: #1cc88a; }
    .badge-warning { background-color: #f6c23e; }
    .table td, .table th { padding: 1rem 0.75rem; }
</style>
