<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header">
                <strong><?= __('Actions') ?></strong>
            </div>
            <div class="list-group list-group-flush">
                <?= $this->Html->link(__('Edit Tag'), ['action' => 'edit', $tag->id], ['class' => 'list-group-item list-group-item-action']) ?>
                <?= $this->Form->postLink(
                    __('Delete Tag'),
                    ['action' => 'delete', $tag->id],
                    [
                        'confirm' => __('Are you sure you want to delete # {0}?', $tag->id),
                        'class' => 'list-group-item list-group-item-action text-danger'
                    ]
                ) ?>
                <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'list-group-item list-group-item-action']) ?>
                <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'list-group-item list-group-item-action']) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><?= h($tag->name) ?></h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td><?= h($tag->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Slug') ?></th>
                        <td><?= h($tag->slug) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Id') ?></th>
                        <td><?= $this->Number->format($tag->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($tag->created) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($tag->modified) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <?php if (!empty($tag->posts)) : ?>
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= __('Related Posts') ?></h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Title') ?></th>
                                <th><?= __('Category Id') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Published') ?></th>
                                <th class="text-center"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tag->posts as $post) : ?>
                                <tr>
                                    <td><?= h($post->id) ?></td>
                                    <td><?= h($post->title) ?></td>
                                    <td><?= h($post->category_id) ?></td>
                                    <td><?= h($post->created) ?></td>
                                    <td><?= h($post->status) ?></td>
                                    <td><?= h($post->published) ?></td>
                                    <td class="text-nowrap text-center">
                                        <?= $this->Html->link(__('View'), ['controller' => 'Posts', 'action' => 'view', $post->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'Posts', 'action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['controller' => 'Posts', 'action' => 'delete', $post->id],
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
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

