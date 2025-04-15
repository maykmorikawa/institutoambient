<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $profiles
 */
?>

<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-header">
                <strong><?= __('Actions') ?></strong>
            </div>
            <div class="list-group list-group-flush">
                <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'list-group-item list-group-item-action']) ?>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Add User') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($user) ?>

                <div class="mb-3">
                    <?= $this->Form->control('profile_id', [
                        'label' => __('Profile'),
                        'options' => $profiles,
                        'empty' => 'selecione',
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('name', [
                        'label' => __('Name'),
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('email', [
                        'label' => __('Email'),
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('password', [
                        'label' => __('Password'),
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
