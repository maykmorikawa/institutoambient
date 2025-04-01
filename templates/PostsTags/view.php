<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostsTag $postsTag
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Posts Tag'), ['action' => 'edit', $postsTag->post_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Posts Tag'), ['action' => 'delete', $postsTag->post_id], ['confirm' => __('Are you sure you want to delete # {0}?', $postsTag->post_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Posts Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Posts Tag'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postsTags view content">
            <h3><?= h($postsTag->Array) ?></h3>
            <table>
                <tr>
                    <th><?= __('Post') ?></th>
                    <td><?= $postsTag->hasValue('post') ? $this->Html->link($postsTag->post->title, ['controller' => 'Posts', 'action' => 'view', $postsTag->post->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= $postsTag->hasValue('tag') ? $this->Html->link($postsTag->tag->name, ['controller' => 'Tags', 'action' => 'view', $postsTag->tag->id]) : '' ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>