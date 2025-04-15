<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $profiles
 */
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <?= $user->isNew() ? __('Add User') : __('Edit User') ?>
        </h6>
        <div>
            <?php if (!$user->isNew()): ?>
                <?= $this->Form->postLink(
                    __('Delete'),
                    ['action' => 'delete', $user->id],
                    ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'btn btn-sm btn-danger']
                ) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary']) ?>
        </div>
    </div>
    <div class="card-body">
        <?= $this->Form->create($user) ?>
        <div class="mb-3">
            <?= $this->Form->control('profile_id', [
                'options' => $profiles,
                'empty' => true,
                'class' => 'form-control',
                'label' => 'Perfil',
            ]) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('name', [
                'class' => 'form-control',
                'label' => 'Nome',
            ]) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('email', [
                'class' => 'form-control',
                'label' => 'E-mail',
            ]) ?>
        </div>
        <div class="mb-3">
            <?= $this->Form->control('password', [
                'class' => 'form-control',
                'label' => 'Senha',
                'value' => '', // ⚠️ Deixa o campo vazio
                'required' => false // Opcionalmente não obrigatório
            ]) ?>
        </div>
        <div class="text-end">
            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>
