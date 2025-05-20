<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 * @var string[]|\Cake\Collection\CollectionInterface $projetos
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><?= __('Editar Atividade') ?></h4>
                <?= $this->Form->postLink(
                    '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                    ['action' => 'delete', $atividade->id],
                    ['confirm' => __('Tem certeza que deseja excluir a atividade #{0}?', $atividade->id), 'class' => 'btn btn-outline-danger', 'escape' => false]
                ) ?>
            </div>
            <div class="card-body">
                <?= $this->Form->create($atividade) ?>
                    <fieldset>
                        <legend><?= __('Informações da Atividade') ?></legend>
                        <div class="mb-3">
                            <?= $this->Form->control('projeto_id', ['options' => $projetos, 'empty' => true, 'class' => 'form-control', 'label' => 'Projeto']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('nome', ['class' => 'form-control', 'label' => 'Nome']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => 'Descrição', 'type' => 'textarea']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('vagas', ['class' => 'form-control', 'label' => 'Vagas']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('local', ['class' => 'form-control', 'label' => 'Local']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('horario', ['class' => 'form-control', 'label' => 'Horário', 'empty' => true]) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('dias_semana', ['class' => 'form-control', 'label' => 'Dias da Semana']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'label' => 'Usuário']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('slug', ['class' => 'form-control', 'label' => 'Slug']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('link_inscricao', ['class' => 'form-control', 'label' => 'Link Inscrição']) ?>
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