<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PostImage $postImage
 * @var string[]|\Cake\Collection\CollectionInterface $posts
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $postImage->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $postImage->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Post Images'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="postImages form content">
            <?= $this->Form->create($postImage) ?>
            <fieldset>
                <legend><?= __('Edit Post Image') ?></legend>
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
