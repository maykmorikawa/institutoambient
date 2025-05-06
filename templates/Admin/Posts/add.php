<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">                
                <h4 class="mb-0"><?= __('Add Post') ?></h4>
            </div>
            <div class="card-body">
            <?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) ?>
                
                <div class="mb-3">
                    <?= $this->Form->control('title', ['class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('content', ['class' => 'form-control', 'rows' => 5]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('category_id', [
                        'options' => $categories,
                        'class' => 'form-control',
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('user_id', [
                        'options' => $users,
                        'class' => 'form-control',
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('slug', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('excerpt', ['class' => 'form-control', 'rows' => 3]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('image', ['class' => 'form-control','type' => 'file']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('status', [
                        'label' => 'Status',
                        'options' => [
                            'rascunho' => 'Rascunho',
                            'publicado' => 'Publicado'
                        ],
                        'empty' => 'Selecione um status',
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('published', ['empty' => true, 'class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('tags._ids', [
                        'options' => $tags,
                        'class' => 'form-select',
                        'multiple' => true,
                        'label' => __('Tags Relacionadas')
                    ]) ?>
                </div>

                <div class="d-grid">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
