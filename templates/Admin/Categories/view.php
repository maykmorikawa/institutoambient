<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>

<div class="row">
    <div class="col-md-3">
        <div class="list-group mb-3">
            <?= $this->Html->link(__('Edit Category'), ['action' => 'edit', $category->id], ['class' => 'list-group-item list-group-item-action']) ?>
            <?= $this->Form->postLink(
                __('Delete Category'),
                ['action' => 'delete', $category->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $category->id), 'class' => 'list-group-item list-group-item-action text-danger']
            ) ?>
            <?= $this->Html->link(__('List Categories'), ['action' => 'index'], ['class' => 'list-group-item list-group-item-action']) ?>
            <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'list-group-item list-group-item-action']) ?>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><?= h($category->name) ?></h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($category->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Slug') ?></th>
                        <td><?= h($category->slug) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Parent Category') ?></th>
                        <td>
                            <?= $category->hasValue('parent_category') ? $this->Html->link($category->parent_category->name, ['action' => 'view', $category->parent_category->id]) : '-' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $this->Number->format($category->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Lft') ?></th>
                        <td><?= $this->Number->format($category->lft) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Rght') ?></th>
                        <td><?= $this->Number->format($category->rght) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($category->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($category->modified) ?></td>
                    </tr>
                </table>

                <?php if (!empty($category->description)) : ?>
                <div class="mt-4">
                    <h5><?= __('Description') ?></h5>
                    <p class="text-muted"><?= $this->Text->autoParagraph(h($category->description)) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if (!empty($category->child_categories)) : ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5><?= __('Child Categories') ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="text-center"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category->child_categories as $child) : ?>
                        <tr>
                            <td><?= h($child->name) ?></td>
                            <td><?= h($child->slug) ?></td>
                            <td><?= h($child->created) ?></td>
                            <td class="text-center">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $child->id], ['class' => 'btn btn-sm btn-outline-secondary me-1']) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $child->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $child->id], [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $child->id),
                                    'class' => 'btn btn-sm btn-outline-danger'
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($category->posts)) : ?>
        <div class="card">
            <div class="card-header">
                <h5><?= __('Posts in this Category') ?></h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Published') ?></th>
                            <th class="text-center"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category->posts as $post) : ?>
                        <tr>
                            <td><?= h($post->title) ?></td>
                            <td><?= h($post->status) ?></td>
                            <td><?= h($post->published) ?></td>
                            <td class="text-center">
                                <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $post->id], ['class' => 'btn btn-sm btn-outline-secondary me-1']) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-outline-primary me-1']) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Posts', 'action' => 'delete', $post->id], [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $post->id),
                                    'class' => 'btn btn-sm btn-outline-danger'
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
