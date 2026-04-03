<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-circle me-2 text-primary"></i><?= __('Detalhes do Usuário') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-list fa-sm text-white-50 me-1"></i> Lista de Usuários', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Editar', ['action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-user-plus fa-sm text-white-50 me-1"></i> Novo Usuário', ['action' => 'add'], ['class' => 'btn btn-sm btn-success', 'escape' => false]) ?>
    </div>
</div>

<div class="row">
    <!-- Informações do Usuário -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow h-100 border-left-primary">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Perfil') ?></h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="h5 font-weight-bold text-dark mb-1"><?= h($user->name) ?></h2>
                    <div class="text-muted small mb-2"><i class="fas fa-envelope me-1"></i><?= h($user->email) ?></div>
                    
                    <?php if (!empty($user->profile)): ?>
                        <span class="badge badge-primary px-3 py-2 mt-1 shadow-sm">
                            <i class="fas fa-shield-alt me-1"></i> <?= h($user->profile->name) ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <ul class="list-group list-group-flush small mt-4 border-top pt-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-fingerprint me-2"></i>ID</span>
                        <span class="font-weight-bold text-dark">#<?= $this->Number->format($user->id) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-calendar-plus me-2"></i>Criado em</span>
                        <span class="text-dark"><?= h($user->created->format('d/m/Y H:i')) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-calendar-check me-2"></i>Modificado em</span>
                        <span class="text-dark"><?= h($user->modified->format('d/m/Y H:i')) ?></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="fas fa-newspaper me-2"></i>Posts Criados</span>
                        <span class="badge badge-info badge-pill shadow-sm"><?= !empty($user->posts) ? count($user->posts) : 0 ?></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-8 mb-4">
        <!-- Postagens Criadas pelo Usuário -->
        <div class="card shadow h-100">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Postagens Autórais') . (!empty($user->posts) ? ' (' . count($user->posts) . ')' : '') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <?php if (!empty($user->posts)) : ?>
                    <table class="table table-hover align-middle mb-0 border-0">
                        <thead class="bg-light text-dark small text-uppercase">
                            <tr>
                                <th class="border-0 px-4"><?= __('Título') ?></th>
                                <th class="border-0 text-center"><?= __('Status') ?></th>
                                <th class="border-0 text-center"><?= __('Publicado em') ?></th>
                                <th class="border-0 text-center px-4"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($user->posts as $post) : ?>
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
                                    <td class="text-center small">
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
                            <div class="mb-3"><i class="fas fa-pen-alt fa-3x text-gray-300"></i></div>
                            <h5 class="text-muted">Este usuário ainda não criou nenhuma publicação.</h5>
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
