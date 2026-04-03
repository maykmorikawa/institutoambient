<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-tag me-2 text-primary"></i><?= __('Detalhes da Tag') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-list fa-sm text-white-50 me-1"></i> Lista de Tags', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Editar', ['action' => 'edit', $tag->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50 me-1"></i> Nova Tag', ['action' => 'add'], ['class' => 'btn btn-sm btn-success', 'escape' => false]) ?>
    </div>
</div>

<div class="row">
    <!-- Informações da Tag -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100 border-left-primary">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Informações Básicas') ?></h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="display-4 text-primary mb-2">
                        <i class="fas fa-hashtag"></i>
                    </div>
                    <h2 class="h4 font-weight-bold text-dark mb-0"><?= h($tag->name) ?></h2>
                    <span class="badge badge-light border px-3 py-2 mt-2">
                        <code><?= h($tag->slug) ?></code>
                    </span>
                </div>
                
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-fingerprint me-2"></i>ID</span>
                        <span class="font-weight-bold text-dark">#<?= $this->Number->format($tag->id) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-calendar-plus me-2"></i>Criado em</span>
                        <span class="text-dark"><?= h($tag->created->format('d/m/Y H:i')) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-calendar-check me-2"></i>Modificado em</span>
                        <span class="text-dark"><?= h($tag->modified->format('d/m/Y H:i')) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-newspaper me-2"></i>Total de Posts</span>
                        <span class="badge badge-primary badge-pill"><?= !empty($tag->posts) ? count($tag->posts) : 0 ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Postagens Relacionadas -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Postagens Vinculadas') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <?php if (!empty($tag->posts)) : ?>
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
                            <?php foreach ($tag->posts as $post) : ?>
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
                            <div class="mb-3"><i class="fas fa-folder-open fa-3x text-gray-300"></i></div>
                            <h5 class="text-muted">Nenhuma postagem vinculada a esta tag.</h5>
                            <?= $this->Html->link('Vincular a um Post', ['action' => 'edit', $tag->id], ['class' => 'btn btn-sm btn-link']) ?>
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
    .badge-primary { background-color: #4e73df; }
    .table td, .table th { padding: 1rem 0.75rem; }
</style>
