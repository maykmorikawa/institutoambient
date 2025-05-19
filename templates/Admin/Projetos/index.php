<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Projeto> $projetos
 */

$statusCores = [
    'planejamento' => 'info',    // Azul claro
    'andamento'   => 'warning', // Amarelo
    'concluido'   => 'success', // Verde
    'cancelado'   => 'danger',  // Vermelho
];
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= __('Projetos') ?></h3>
            <?= $this->Html->link('<i class="bi bi-plus-square"></i> ' . __('Novo Projeto'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                            <th><?= $this->Paginator->sort('data_inicio', 'Início') ?></th>
                            <th><?= $this->Paginator->sort('data_fim', 'Fim') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Usuário') ?></th>
                            <th><?= $this->Paginator->sort('ublicado', 'Publicado') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modificado em') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projetos as $projeto): ?>
                        <tr>
                            <td><?= $this->Number->format($projeto->id) ?></td>
                            <td><?= h($projeto->name) ?></td>
                            <td><?= $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' ?></td>
                            <td><?= $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '-' ?></td>
                            <td>
                                <?php if (isset($statusCores[$projeto->status])) : ?>
                                    <span class="badge bg-<?= $statusCores[$projeto->status] ?> text-white"><?= h($projeto->status) ?></span>
                                <?php else : ?>
                                    <?= h($projeto->status) ?>
                                <?php endif; ?>
                            </td>
                            <td><?= $projeto->hasValue('user') ? $this->Html->link($projeto->user->name, ['controller' => 'Users', 'action' => 'view', $projeto->user->id]) : '' ?></td>
                            <td><?= $projeto->ublicado ? '<span class="badge bg-success text-white">Sim</span>' : '<span class="badge bg-danger text-white">Não</span>' ?></td>
                            <td><?= $projeto->created ? $projeto->created->format('d/m/Y H:i') : '-' ?></td>
                            <td><?= $projeto->modified ? $projeto->modified->format('d/m/Y H:i') : '-' ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['action' => 'view', $projeto->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $projeto->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['action' => 'delete', $projeto->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'confirm' => __('Tem certeza que deseja excluir o projeto #{0}?', $projeto->id),
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator mt-3">
                <ul class="pagination">
                    <?= $this->Paginator->first('<i class="bi bi-chevron-double-left"></i> ' . __('primeira'), ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="bi bi-chevron-left"></i> ' . __('anterior'), ['escape' => false]) ?>
                    <?= $this->Paginator->numbers(['separator' => '']) ?>
                    <?= $this->Paginator->next(__('próxima') . ' <i class="bi bi-chevron-right"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->last(__('última') . ' <i class="bi bi-chevron-double-right"></i>', ['escape' => false]) ?>
                </ul>
                <p class="mt-2"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} no total')) ?></p>
            </div>
        </div>
    </div>
</div>