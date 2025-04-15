<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Post> $posts
 */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= __('Posts') ?></h6>
        <?= $this->Html->link(__('Novo Post'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('title') ?></th>
                        <th><?= $this->Paginator->sort('category_id', 'Categoria') ?></th>
                        <th><?= $this->Paginator->sort('user_id', 'Autor') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>
                        <th><?= $this->Paginator->sort('published', 'Publicado') ?></th>
                        <th><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td><?= $this->Number->format($post->id) ?></td>
                            <td><?= h($post->title) ?></td>
                            <td>
                                <?= $post->hasValue('category')
                                    ? $this->Html->link($post->category->name, ['controller' => 'Categories', 'action' => 'view', $post->category->id], ['class' => 'text-decoration-none'])
                                    : '<span class="text-muted">-</span>' ?>
                            </td>
                            <td>
                                <?= $post->hasValue('user')
                                    ? $this->Html->link($post->user->name, ['controller' => 'Users', 'action' => 'view', $post->user->id], ['class' => 'text-decoration-none'])
                                    : '<span class="text-muted">-</span>' ?>
                            </td>
                            <td><?= h($post->created->format('d/m/Y H:i')) ?></td>
                            <td>
                                <span class="badge bg-<?= $post->status === 'ativo' ? 'success' : 'secondary' ?>">
                                    <?= h(ucfirst($post->status)) ?>
                                </span>
                            </td>
                            <td>
                                <?= $post->published
                                    ? '<span class="badge bg-primary">Sim</span>'
                                    : '<span class="badge bg-warning text-dark">Não</span>' ?>
                            </td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $post->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $post->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $post->id),
                                        'class' => 'btn btn-sm btn-outline-danger'
                                    ]
                                ) ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator mt-3">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->numbers(['class' => 'page-link']) ?>
                <?= $this->Paginator->next(__('next') . ' >', ['class' => 'page-link']) ?>
                <?= $this->Paginator->last(__('last') . ' >>', ['class' => 'page-link']) ?>
            </ul>
            <p class="text-center">
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </p>
        </div>
    </div>