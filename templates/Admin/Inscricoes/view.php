<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 */
?>
<div class="row">
    <div class="col-md-10 offset-md-1">
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
                        <td><?= $inscrico->hasValue('aluno') ? $this->Html->link($inscrico->aluno->nome_completo, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Aluno') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Atividade') ?></th>
                        <td><?= $inscrico->hasValue('atividade') ? $this->Html->link($inscrico->atividade->nome, ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Atividade') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Usuário') ?></th>
                        <td><?= $inscrico->hasValue('user') ? $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id]) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Responsável') ?></th>
                        <td><?= $inscrico->hasValue('responsavel') ? $this->Html->link($inscrico->responsavel->name, ['controller' => 'Users', 'action' => 'view', $inscrico->responsavel->id]) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data de Inscrição') ?></th>
                        <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= h($inscrico->status) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Criado') ?></th>
                        <td><?= $inscrico->created ? $inscrico->created->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modificado') ?></th>
                        <td><?= $inscrico->modified ? $inscrico->modified->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer">
                <?= $this->Html->link('<i class="bi bi-arrow-left-square-fill"></i> ' . __('Listar Inscrições'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                <?= $this->Html->link('<i class="bi bi-plus-circle-fill"></i> ' . __('Nova Inscrição'), ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
            </div>
        </div>

        <?php if ($inscrico->has('aluno')) : ?>
        <div class="card mt-4">
            <div class="card-header">
                <h4><?= __('Detalhes do Aluno Relacionado') ?></h4>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th><?= __('Nome Completo') ?></th>
                        <td><?= h($inscrico->aluno->nome_completo) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= h($inscrico->aluno->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('CPF') ?></th>
                        <td><?= h($inscrico->aluno->cpf) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Telefone') ?></th>
                        <td><?= h($inscrico->aluno->telefone) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data de Nascimento') ?></th>
                        <td><?= $inscrico->aluno->data_nascimento ? $inscrico->aluno->data_nascimento->format('d/m/Y') : '-' ?></td>
                    </tr>
                </table>
                <?= $this->Html->link(__('Ver Aluno Completo'), ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id], ['class' => 'btn btn-sm btn-primary mt-3']) ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
