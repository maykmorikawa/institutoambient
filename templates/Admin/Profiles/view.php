<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Profile $profile
 */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= h($profile->name) ?></h2>
        <div>
            <?= $this->Html->link(__('Voltar'), ['action' => 'index'], ['class' => 'btn btn-outline-primary me-2']) ?>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Editar', ['action' => 'edit', $profile->id], ['class' => 'btn btn-outline-secondary me-2', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="bi bi-trash"></i> Excluir', ['action' => 'delete', $profile->id], [
                'class' => 'btn btn-outline-danger',
                'escape' => false,
                'confirm' => __('Tem certeza que deseja excluir o perfil #{0}?', $profile->id),
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold"><?= __('Detalhes do Perfil') ?></div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($profile->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Descrição') ?></th>
                    <td><?= h($profile->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($profile->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= $profile->created ? $profile->created->format('d/m/Y H:i') : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Modificado em') ?></th>
                    <td><?= $profile->modified ? $profile->modified->format('d/m/Y H:i') : '-' ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (!empty($profile->users)) : ?>
        <div class="card mb-4">
            <div class="card-header fw-bold"><?= __('Usuários Relacionados') ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Nome') ?></th>
                                <th><?= __('Email') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($profile->users as $user) : ?>
                                <tr>
                                    <td><?= h($user->id) ?></td>
                                    <td><?= h($user->name) ?></td>
                                    <td><?= h($user->email) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Users', 'action' => 'view', $user->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Users', 'action' => 'edit', $user->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Users', 'action' => 'delete', $user->id], [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'escape' => false,
                                            'confirm' => __('Tem certeza que deseja excluir o usuário #{0}?', $user->id),
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>