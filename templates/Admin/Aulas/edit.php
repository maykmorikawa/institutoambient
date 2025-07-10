<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 * @var string[]|\Cake\Collection\CollectionInterface $atividades
 */
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= __('Editar Aula') ?></h3>
            <?= $this->Html->link('<i class="bi bi-list"></i> ' . __('Listar Aulas'), ['action' => 'index'], ['class' => 'btn btn-info text-white', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="aulas form content">
                <?= $this->Form->create($aula) ?>
                <fieldset>
                    <legend class="h5 mb-4"><?= __('Dados da Aula') ?></legend>
                    <?php
                        echo $this->Form->control('atividade_id', ['options' => $atividades, 'class' => 'form-control mb-3', 'label' => 'Atividade']);
                        echo $this->Form->control('data', ['class' => 'form-control mb-3', 'type' => 'date', 'label' => 'Data']);
                        echo $this->Form->control('conteudo', ['class' => 'form-control mb-3', 'label' => 'Conteúdo', 'rows' => 5]);
                        echo $this->Form->control('observacoes', ['class' => 'form-control mb-3', 'label' => 'Observações', 'rows' => 3]);
                    ?>
                </fieldset>
                <?= $this->Form->button('<i class="bi bi-save"></i> ' . __('Salvar Aula'), ['class' => 'btn btn-success mt-3', 'escapeTitle' => false]) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
