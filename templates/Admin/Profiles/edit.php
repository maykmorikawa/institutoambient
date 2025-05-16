<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Profile $profile
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Editar Perfil') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($profile) ?>
                <fieldset>
                    <legend><?= __('Informações do Perfil') ?></legend>
                    <div class="mb-3">
                        <?= $this->Form->control('name', ['class' => 'form-control', 'label' => 'Nome']) ?>
                    </div>
                </fieldset>
                <div class="mt-4 d-flex">
                    <?= $this->Form->button(__('Salvar Alterações'), ['class' => 'btn btn-primary', 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>