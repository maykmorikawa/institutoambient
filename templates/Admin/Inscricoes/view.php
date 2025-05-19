<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= __('Inscrição') ?> #<?= h($inscrico->id) ?></h3>
                <div>
                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                        ['action' => 'delete', $inscrico->id],
                        ['confirm' => __('Tem certeza que deseja excluir a inscrição #{0}?', $inscrico->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]
                    ) ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><?= __('Aluno') ?></th>
                        <td><?= $inscrico->hasValue('aluno') ? $this->Html->link($inscrico->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Aluno') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Atividade') ?></th>
                        <td><?= $inscrico->hasValue('atividade') ? $this->Html->link($inscrico->atividade->titulo, ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Atividade') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Usuário') ?></th>
                        <td><?= $inscrico->hasValue('user') ? $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Responsável') ?></th>
                        <td><?= $inscrico->hasValue('responsavel') ? $this->Html->link($inscrico->responsavel->name, ['controller' => 'Users', 'action' => 'view', $inscrico->responsavel->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Responsável') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= h($inscrico->status) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><?= $this->Number->format($inscrico->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data Inscrição') ?></th>
                        <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-start">
                <?= $this->Html->link('<i class="bi bi-arrow-left-square-fill"></i> ' . __('Listar Inscrições'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                <?= $this->Html->link('<i class="bi bi-plus-square-fill"></i> ' . __('Nova Inscrição'), ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
            </div>
        </div>
    </div>
</div>