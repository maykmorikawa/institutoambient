<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $atividades
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Adicionar Aluno') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($aluno, ['class' => 'user']) ?>
                <div class="row">

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('nome', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('email', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('cpf', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('rg', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('nis', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('data_nascimento', [
                            'empty' => true,
                            'class' => 'form-control',
                            'label' => 'Data de Nascimento'
                        ]) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('telefone', ['class' => 'form-control']) ?>
                    </div>

                    <div class="mb-3 col-md-6">
                        <?= $this->Form->control('atividade_id', [
                            'options' => $atividades,
                            'empty' => 'Selecione uma atividade',
                            'class' => 'form-control'
                        ]) ?>
                    </div>

                </div>

                <div class="mt-4 d-flex">
                    <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary','style' => 'margin-right: 10px;']) ?>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>