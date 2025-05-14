<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostImage $postImage
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Post Image'), ['action' => 'edit', $postImage->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Post Image'), ['action' => 'delete', $postImage->id], ['confirm' => __('Are you sure you want to delete # {0}?', $postImage->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Post Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Post Image'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postImages view content">
            <h3><?= h($postImage->filename) ?></h3>
            <table>
                <tr>
                    <th><?= __('Post') ?></th>
                    <td><?= $postImage->hasValue('post') ? $this->Html->link($postImage->post->title, ['controller' => 'Posts', 'action' => 'view', $postImage->post->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Filename') ?></th>
                    <td><?= h($postImage->filename) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($postImage->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($postImage->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>