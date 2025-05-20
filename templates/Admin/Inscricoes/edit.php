<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 * @var string[]|\Cake\Collection\CollectionInterface $alunos
 * @var string[]|\Cake\Collection\CollectionInterface $atividades
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $responsavels
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><?= __('Editar Inscrição') ?></h4>
                <?= $this->Form->postLink(
                    '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                    ['action' => 'delete', $inscrico->id],
                    ['confirm' => __('Tem certeza que deseja excluir a inscrição #{0}?', $inscrico->id), 'class' => 'btn btn-outline-danger', 'escape' => false]
                ) ?>
            </div>
            <div class="card-body">
                <?= $this->Form->create($inscrico) ?>
                <fieldset>
                    <legend><?= __('Informações da Inscrição') ?></legend>
                    <div class="mb-3">
                        <?= $this->Form->control('aluno_id', ['options' => $alunos, 'class' => 'form-control', 'label' => 'Aluno']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('atividade_id', ['options' => $atividades, 'class' => 'form-control', 'label' => 'Atividade']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('user_id', ['options' => $users, 'empty' => true, 'class' => 'form-control', 'label' => 'Usuário']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('responsavel_id', ['options' => $responsavels, 'empty' => true, 'class' => 'form-control', 'label' => 'Responsável']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('data_inscricao', ['class' => 'form-control', 'label' => 'Data Inscrição']) ?>
                    </div>
                    <div class="mb-3">
                        <?= $this->Form->control('status', [
                            'class' => 'form-control',
                            'label' => 'Status',
                            'options' => [
                                'pendente' => __('Pendente'),
                                'confirmada' => __('Confirmada'),
                                'cancelada' => __('Cancelado'),
                            ],
                        ]) ?>
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