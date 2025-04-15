<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var \Cake\Collection\CollectionInterface|string[] $posts
 */
?>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header">
                <strong><?= __('Actions') ?></strong>
            </div>
            <div class="list-group list-group-flush">
                <?= $this->Html->link(__('List Tags'), ['action' => 'index'], ['class' => 'list-group-item list-group-item-action']) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Add Tag') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($tag) ?>
                <div class="mb-3">
                    <?= $this->Form->control('name', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('slug', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->label('posts._ids', __('Related Posts'), ['class' => 'form-label']) ?>
                    <?= $this->Form->select('posts._ids', $posts, [
                        'multiple' => true,
                        'class' => 'form-control',
                        'size' => 8 // número de itens visíveis
                    ]) ?>
                </div>
                <div>
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>