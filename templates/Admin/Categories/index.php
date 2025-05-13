<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0"><?= __('Categories') ?></h4>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><?= $this->Paginator->sort('id') ?></th>
                            <th><?= $this->Paginator->sort('name') ?></th>
                            <th><?= $this->Paginator->sort('slug') ?></th>
                            <th><?= $this->Paginator->sort('created') ?></th>
                            <th><?= $this->Paginator->sort('modified') ?></th>
                            <th><?= $this->Paginator->sort('parent_id', 'Categoria Pai') ?></th>
                            <th class="text-center"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $this->Number->format($category->id) ?></td>
                            <td><?= h($category->name) ?></td>
                            <td><?= h($category->slug) ?></td>
                            <td><?= h($category->created) ?></td>
                            <td><?= h($category->modified) ?></td>
                            <td>
                                <?php if (!empty($category->parent_category)): ?>
                                    <?= $this->Html->link(
                                        $category->parent_category->name,
                                        ['action' => 'view', $category->parent_category->id]
                                    ) ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $category->id], ['class' => 'btn btn-sm btn-outline-secondary me-1']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $category->id],
                                    [
                                        'confirm' => __('Are you sure you want to delete # {0}?', $category->id),
                                        'class' => 'btn btn-sm btn-outline-danger'
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
                    </div>
                    <div>
                        <ul class="pagination mb-0">
                            <?= $this->Paginator->first('<<') ?>
                            <?= $this->Paginator->prev('<') ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next('>') ?>
                            <?= $this->Paginator->last('>>') ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
