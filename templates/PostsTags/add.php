<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostsTag $postsTag
 * @var \Cake\Collection\CollectionInterface|string[] $posts
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Posts Tags'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postsTags form content">
            <?= $this->Form->create($postsTag) ?>
            <fieldset>
                <legend><?= __('Add Posts Tag') ?></legend>
                <?php
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
