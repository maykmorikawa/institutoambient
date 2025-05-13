<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 * @var \Cake\Collection\CollectionInterface|string[] $parentCategories
 */
?>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Add Category') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($category) ?>

                <div class="mb-3">
                    <?= $this->Form->control('name', ['class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('slug', ['class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('description', [
                        'class' => 'form-control',
                        'rows' => 3
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('parent_id', [
                        'label' => 'Categoria Pai',
                        'options' => $parentCategories,
                        'empty' => 'Nenhuma (Categoria Principal)',
                        'class' => 'form-control'
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
