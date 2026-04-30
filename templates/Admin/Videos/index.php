<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Video> $videos
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
$this->assign('title', 'Galeria de Vídeos');
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom-primary">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-video me-2"></i><?= __('Listagem de Vídeos') ?>
        </h6>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-icon-split btn-sm">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text"><?= __('Novo Vídeo') ?></span>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th style="width: 150px;">Miniatura</th>
                        <th><?= $this->Paginator->sort('title', 'Título') ?></th>
                        <th><?= $this->Paginator->sort('video_url', 'URL do Vídeo') ?></th>
                        <th style="width: 120px;"><?= $this->Paginator->sort('created', 'Data') ?></th>
                        <th class="text-center" style="width: 150px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($videos as $video): ?>
                        <tr>
                            <td>
                                <?php if ($video->background_image): ?>
                                    <img src="<?= $this->Url->build('/img/uploads/' . $video->background_image) ?>" 
                                         class="rounded shadow-sm" style="width: 120px; height: 67px; object-fit: cover;" alt="Min.">
                                <?php else: ?>
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center border" style="width: 120px; height: 67px;">
                                        <i class="fas fa-video text-muted"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-0"><?= h($video->title) ?></div>
                            </td>
                            <td>
                                <a href="<?= h($video->video_url) ?>" target="_blank" class="small text-truncate d-inline-block" style="max-width: 200px;">
                                    <?= h($video->video_url) ?>
                                </a>
                            </td>
                            <td>
                                <div class="small">
                                    <?= $video->created->format('d/m/Y') ?><br>
                                    <span class="text-muted small"><?= $video->created->format('H:i') ?></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $video->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $video->id], [
                                        'confirm' => __('Deseja realmente excluir este vídeo?'),
                                        'class' => 'btn btn-sm btn-white',
                                        'title' => 'Excluir',
                                        'escape' => false
                                    ]) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($videos->count() === 0): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Nenhum vídeo cadastrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Paginação -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 small text-muted">
                <?= $this->Paginator->counter('Mostrando de {{start}} a {{end}} de um total de {{count}} registros') ?>
            </div>
            <nav aria-label="Navegação de vídeos">
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
</style>
