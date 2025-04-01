<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostsTag $postsTag
 * @var string[]|\Cake\Collection\CollectionInterface $posts
 * @var string[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postsTag->post_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postsTag->post_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Posts Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postsTags form content">
            <?= $this->Form->create($postsTag) ?>
            <fieldset>
                <legend><?= __('Edit Posts Tag') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
