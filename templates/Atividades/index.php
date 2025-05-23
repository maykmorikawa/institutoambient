<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Atividade> $atividades
 */
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="container-fluid mt-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="mb-0"><?= __('Projetos') ?></h3>
                        <?= $this->Html->link('<i class="bi bi-plus-square"></i> ' . __('Novo Projeto'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
                    </div>
                    <div class="card-body">
                        <div class="atividades index content">
                            <?= $this->Html->link(__('New Atividade'), ['action' => 'add'], ['class' => 'button float-right']) ?>
                            <h3><?= __('Atividades') ?></h3>
                            <div class="table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th><?= $this->Paginator->sort('id') ?></th>
                                            <th><?= $this->Paginator->sort('projeto_id') ?></th>
                                            <th><?= $this->Paginator->sort('nome') ?></th>
                                            <th><?= $this->Paginator->sort('vagas') ?></th>
                                            <th><?= $this->Paginator->sort('local') ?></th>
                                            <th><?= $this->Paginator->sort('horario') ?></th>
                                            <th><?= $this->Paginator->sort('dias_semana') ?></th>
                                            <th><?= $this->Paginator->sort('user_id') ?></th>
                                            <th><?= $this->Paginator->sort('slug') ?></th>
                                            <th><?= $this->Paginator->sort('link_inscricao') ?></th>
                                            <th><?= $this->Paginator->sort('publicado') ?></th>
                                            <th><?= $this->Paginator->sort('created') ?></th>
                                            <th><?= $this->Paginator->sort('modified') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($atividades as $atividade): ?>
                                            <tr>
                                                <td><?= $this->Number->format($atividade->id) ?></td>
                                                <td><?= $atividade->hasValue('projeto') ? $this->Html->link($atividade->projeto->titulo, ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id]) : '' ?></td>
                                                <td><?= h($atividade->nome) ?></td>
                                                <td><?= $this->Number->format($atividade->vagas) ?></td>
                                                <td><?= h($atividade->local) ?></td>
                                                <td><?= h($atividade->horario) ?></td>
                                                <td><?= h($atividade->dias_semana) ?></td>
                                                <td><?= $atividade->hasValue('user') ? $this->Html->link($atividade->user->name, ['controller' => 'Users', 'action' => 'view', $atividade->user->id]) : '' ?></td>
                                                <td><?= h($atividade->slug) ?></td>
                                                <td><?= h($atividade->link_inscricao) ?></td>
                                                <td><?= h($atividade->publicado) ?></td>
                                                <td><?= h($atividade->created) ?></td>
                                                <td><?= h($atividade->modified) ?></td>
                                                <td class="actions">
                                                    <?= $this->Html->link(__('View'), ['action' => 'view', $atividade->id]) ?>
                                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $atividade->id]) ?>
                                                    <?= $this->Form->postLink(
                                                        __('Delete'),
                                                        ['action' => 'delete', $atividade->id],
                                                        [
                                                            'method' => 'delete',
                                                            'confirm' => __('Are you sure you want to delete # {0}?', $atividade->id),
                                                        ]
                                                    ) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="paginator">
                                <ul class="pagination">
                                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                    <?= $this->Paginator->numbers() ?>
                                    <?= $this->Paginator->next(__('next') . ' >') ?>
                                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                                </ul>
                                <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>