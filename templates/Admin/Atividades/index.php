<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Atividade> $atividades
 */
?>
<div class="container mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= __('Atividades') ?></h3>
            <?= $this->Html->link('<i class="bi bi-plus-square"></i> ' . __('Nova Atividade'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('projeto_id', 'Projeto') ?></th>
                            <th><?= $this->Paginator->sort('titulo', 'Título') ?></th>
                            <th><?= $this->Paginator->sort('slug', 'Slug') ?></th>
                            <th><?= $this->Paginator->sort('link_inscricao', 'Link Inscrição') ?></th>
                            <th><?= $this->Paginator->sort('publicado', 'Publicado') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modificado em') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($atividades as $atividade): ?>
                        <tr>
                            <td><?= $this->Number->format($atividade->id) ?></td>
                            <td><?= $atividade->hasValue('projeto') ? $this->Html->link($atividade->projeto->titulo, ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id]) : '' ?></td>
                            <td><?= h($atividade->titulo) ?></td>
                            <td><?= h($atividade->slug) ?></td>
                            <td><?= h($atividade->link_inscricao) ?></td>
                            <td><?= $atividade->publicado ? '<span class="badge bg-success text-white">Sim</span>' : '<span class="badge bg-danger text-white">Não</span>' ?></td>
                            <td><?= $atividade->created ? $atividade->created->format('d/m/Y H:i') : '-' ?></td>
                            <td><?= $atividade->modified ? $atividade->modified->format('d/m/Y H:i') : '-' ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['action' => 'view', $atividade->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['action' => 'delete', $atividade->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'confirm' => __('Tem certeza que deseja excluir a atividade #{0}?', $atividade->id),
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