<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Adicionar Projeto') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($projeto) ?>
                    <fieldset>
                        <legend><?= __('Informações do Projeto') ?></legend>
                        <div class="mb-3">
                            <?= $this->Form->control('titulo', ['class' => 'form-control', 'label' => 'Título']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('publicado', ['class' => 'form-control', 'label' => 'Publicado']) ?>
                        </div>
                    </fieldset>
                    <div class="d-grid">
                        <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>