<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostImage $postImage
 * @var \Cake\Collection\CollectionInterface|string[] $posts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Post Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postImages form content">
            <?= $this->Form->create($postImage) ?>
            <fieldset>
                <legend><?= __('Add Post Image') ?></legend>
                <?php
                    echo $this->Form->control('post_id', ['options' => $posts]);
                    echo $this->Form->control('filename');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
