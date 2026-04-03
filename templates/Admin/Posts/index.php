<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Post> $posts
 */

// Configuração do Paginator para Bootstrap 4/5
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
    'sort' => '<a class="text-primary" href="{{url}}">{{text}} <i class="fas fa-sort-down ms-1 small"></i></a>',
    'sortAsc' => '<a class="text-primary asc" href="{{url}}">{{text}} <i class="fas fa-sort-up ms-1 small"></i></a>',
    'sortDesc' => '<a class="text-primary desc" href="{{url}}">{{text}} <i class="fas fa-sort-down ms-1 small"></i></a>',
]);
?>

<?php
$this->assign('title', 'Postagens');
?>

<!-- Post Dashboard -->
<div class="row mb-4">
    <!-- Total Posts Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Postagens</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalPosts) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Views Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total de Visualizações</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= number_format($totalViews) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top View Tags Card -->
    <div class="col-xl-6 col-md-12 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Top 3 Mais Vistos</div>
                        <div class="small mt-2">
                            <?php foreach ($topPosts->take(3) as $top): ?>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-truncate mr-2" style="max-width: 250px;"><?= h($top->title) ?></span>
                                    <span class="badge badge-warning"><?= $top->view_count ?> vistas</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom-primary">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-list me-2"></i><?= __('Listagem de Postagens') ?>
        </h6>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"><?= __('Novo Post') ?></span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th style="width: 50px;">Min.</th>
                        <th><?= $this->Paginator->sort('title', 'Título') ?></th>
                        <th style="width: 150px;"><?= $this->Paginator->sort('category_id', 'Categoria') ?></th>
                        <th style="width: 100px;" class="text-center"><?= $this->Paginator->sort('view_count', 'Vistas') ?></th>
                        <th style="width: 120px;" class="text-center"><?= $this->Paginator->sort('status') ?></th>
                        <th style="width: 120px;"><?= $this->Paginator->sort('created', 'Data') ?></th>
                        <th class="text-center" style="width: 180px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td>
                                <?php 
                                    $featured = null;
                                    foreach ($post->post_images as $img) {
                                        if ($img->is_featured) {
                                            $featured = $img;
                                            break;
                                        }
                                    }
                                    if ($featured): ?>
                                    <img src="<?= $this->Url->build('/img/uploads/' . $featured->filename) ?>" 
                                         class="rounded shadow-sm" style="width: 45px; height: 45px; object-fit: cover;" alt="Min.">
                                <?php else: ?>
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                        <i class="fas fa-image text-muted small"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-0"><?= h($post->title) ?></div>
                                <small class="text-muted"><i class="fas fa-user me-1"></i><?= h($post->user->name ?? '-') ?></small>
                            </td>
                            <td>
                                <?php if ($post->hasValue('category')): ?>
                                    <span class="badge badge-light border border-primary-subtile text-primary px-3">
                                        <?= h($post->category->name) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted small">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-info shadow-sm" style="font-size: 0.8rem;">
                                    <i class="fas fa-eye me-1"></i> <?= number_format($post->view_count ?? 0) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php if ($post->status === 'publicado'): ?>
                                    <div class="badge badge-success px-3 py-2" style="font-size: 0.7rem; min-width: 90px;">
                                        <i class="fas fa-check-circle me-1"></i> Publicado
                                    </div>
                                <?php else: ?>
                                    <div class="badge badge-warning px-3 py-2 text-dark" style="font-size: 0.7rem; min-width: 90px;">
                                        <i class="fas fa-clock me-1"></i> Rascunho
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small">
                                    <?= $post->created->format('d/m/Y') ?><br>
                                    <span class="text-muted small"><?= $post->created->format('H:i') ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $post->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Visualizar', 'escape' => false]) ?>
                                    <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $post->id], [
                                        'confirm' => __('Deseja realmente excluir este post?'),
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
        
        <!-- Paginação Melhorada -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 small text-muted">
                <?= $this->Paginator->counter('Mostrando de {{start}} a {{end}} de um total de {{count}} registros') ?>
            </div>
            <nav aria-label="Navegação de posts">
                <ul class="pagination pagination-sm mb-0">
                    <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers() ?>
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
    }
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
    }
    .badge {
        font-size: 0.75rem;
        padding: 0.5em 0.8em;
    }
</style>