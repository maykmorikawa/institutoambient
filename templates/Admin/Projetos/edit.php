<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Editar Projeto') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($projeto) ?>
                <fieldset>
                    <legend><?= __('Informações do Projeto') ?></legend>
                    <div class="mb-3">
                        <?= $this->Form->control('titulo', ['class' => 'form-control', 'label' => 'Título']) ?>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <?= $this->Form->checkbox('publicado', [
                                'class' => 'form-check-input',
                                'id' => 'publicado'
                            ]) ?>
                            <label class="form-check-label" for="publicado">
                                <?= __('Publicado') ?>
                            </label>
                        </div>
                    </div>
                </fieldset>
                <div class="mt-4 d-flex">
                    <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary', 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>