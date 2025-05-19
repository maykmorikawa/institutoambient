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
                            <?= $this->Form->control('nome', ['class' => 'form-control', 'label' => 'Nome']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => 'Descrição', 'type' => 'textarea']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('data_inicio', ['class' => 'form-control', 'label' => 'Data Início', 'type' => 'date']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('data_fim', ['class' => 'form-control', 'label' => 'Data Fim', 'type' => 'date']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('status', [
                                'class' => 'form-control',
                                'label' => 'Status',
                                'options' => [
                                    'planejamento' => __('Planejamento'),
                                    'andamento' => __('Andamento'),
                                    'concluido' => __('Concluído'),
                                    'cancelado' => __('Cancelado'),
                                ],
                            ]) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('user_id', ['class' => 'form-control', 'label' => 'Usuário']) ?>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <?= $this->Form->checkbox('ublicado', [
                                    'class' => 'form-check-input',
                                    'id' => 'ublicado'
                                ]) ?>
                                <label class="form-check-label" for="ublicado">
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