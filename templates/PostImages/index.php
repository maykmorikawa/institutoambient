<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PostImage> $postImages
 */
?>
<div class="postImages index content">
    <?= $this->Html->link(__('New Post Image'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Post Images') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('post_id') ?></th>
                    <th><?= $this->Paginator->sort('filename') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($postImages as $postImage): ?>
                <tr>
                    <td><?= $this->Number->format($postImage->id) ?></td>
                    <td><?= $postImage->hasValue('post') ? $this->Html->link($postImage->post->title, ['controller' => 'Posts', 'action' => 'view', $postImage->post->id]) : '' ?></td>
                    <td><?= h($postImage->filename) ?></td>
                    <td><?= h($postImage->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $postImage->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $postImage->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $postImage->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $postImage->id),
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