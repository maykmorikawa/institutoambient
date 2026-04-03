<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
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
            <i class="fas fa-users me-2"></i><?= __('Gerenciar Usuários') ?>
        </h6>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-icon-split btn-sm shadow-sm">
            <span class="icon text-white-50">
                <i class="fas fa-user-plus"></i>
            </span>
            <span class="text"><?= __('Novo Usuário') ?></span>
        </a>
    </div>
    
    <?= $this->Flash->render() ?>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark">
                    <tr>
                        <th style="width: 80px;"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th><?= __('Usuário') ?></th>
                        <th><?= $this->Paginator->sort('profile_id', 'Perfil / Papel') ?></th>
                        <th style="width: 150px;"><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                        <th class="text-center" style="width: 180px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-info-circle me-1"></i> Nenhum usuário cadastrado.
                            </td>
                        </tr>
                    <?php endif; ?>
                    
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="text-muted font-weight-bold small">#<?= $this->Number->format($user->id) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark"><?= h($user->name) ?></div>
                                    <small class="text-muted"><i class="fas fa-envelope me-1"></i><?= h($user->email) ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if (!empty($user->profile)): ?>
                                <span class="badge badge-light border text-primary px-3 py-1 shadow-sm">
                                    <i class="fas fa-id-badge me-1"></i> <?= $this->Html->link($user->profile->name, ['controller' => 'Profiles', 'action' => 'view', $user->profile->id], ['class' => 'text-decoration-none']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted small">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="small">
                            <?= h($user->created->format('d/m/Y')) ?><br>
                            <span class="text-muted"><?= h($user->created->format('H:i')) ?></span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['action' => 'view', $user->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Visualizar', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $user->id], [
                                    'confirm' => __('Deseja realmente excluir o usuário "{0}" e todas as suas dependências?', $user->name),
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
                <?= $this->Paginator->counter('Mostrando de {{start}} a {{end}} de um total de {{count}} usuários') ?>
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
</style>
