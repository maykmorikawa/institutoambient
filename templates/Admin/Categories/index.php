<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */

$this->Paginator->setTemplates([
    'nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'counterRange' => '{{start}} - {{end}} of {{count}}',
    'counterPages' => '{{page}} of {{pages}}',
    'first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active"><span class="page-link">{{text}}</span></li>',
    'ellipsis' => '<li class="page-item disabled"><span class="page-link">...</span></li>',
]);
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom-primary">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-folder me-2"></i><?= __('Gerenciar Categorias') ?>
        </h6>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-icon-split btn-sm shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"><?= __('Nova Categoria') ?></span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th style="width: 80px;"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= $this->Paginator->sort('name', 'Nome da Categoria') ?></th>
                        <th><?= $this->Paginator->sort('slug', 'Slug/URL') ?></th>
                        <th><?= $this->Paginator->sort('parent_id', 'Categoria Pai') ?></th>
                        <th style="width: 150px;"><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                        <th class="text-center" style="width: 180px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($categories->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-1"></i> Nenhuma categoria encontrada.
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td class="text-muted font-weight-bold small">#<?= $this->Number->format($category->id) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="badge badge-success rounded-circle p-2 me-2" style="width: 10px; height: 10px;"></div>
                                <span class="fw-bold text-dark"><?= h($category->name) ?></span>
                            </div>
                        </td>
                        <td>
                            <code class="small bg-light px-2 py-1 rounded text-primary"><?= h($category->slug) ?></code>
                        </td>
                        <td>
                            <?php if (!empty($category->parent_category)): ?>
                                <span class="badge badge-light border text-secondary px-2 py-1">
                                    <i class="fas fa-level-up-alt me-1"></i> <?= $this->Html->link($category->parent_category->name, ['action' => 'view', $category->parent_category->id], ['class' => 'text-decoration-none']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small">
                            <?= h($category->created->format('d/m/Y')) ?><br>
                            <span class="text-muted"><?= h($category->created->format('H:i')) ?></span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['action' => 'view', $category->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Visualizar', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $category->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $category->id], [
                                    'confirm' => __('Deseja realmente excluir a categoria "{0}"?', $category->name),
                                    'class' => 'btn btn-sm btn-white',
                                    'title' => 'Excluir',
                                    'escape' => false
                                ]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Paginação -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 small text-muted">
                <?= $this->Paginator->counter('Mostrando de {{start}} a {{end}} de um total de {{count}} categorias') ?>
            </div>
            <nav aria-label="Navegação">
                <ul class="pagination pagination-sm mb-0 shadow-sm">
                    <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers(['class' => 'page-item', 'linkClass' => 'page-link']) ?>
                    <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    .btn-white {
        background: #fff;
        border: 1px solid #e3e6f0;
    }
    .btn-white:hover {
        background: #f8f9fc;
        border-color: #d1d3e2;
    }
    .table th {
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
        border-top: none;
    }
    .table td {
        border-top: 1px solid #f2f4f9;
        font-size: 0.85rem;
    }
    .badge-success { background-color: #1cc88a; }
</style>
