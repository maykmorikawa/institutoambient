<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Aluno> $alunos
 */
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= __('Alunos') ?></h3>
            <?= $this->Html->link('<i class="bi bi-person-plus-fill"></i> ' . __('Novo Aluno'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Usuário') ?></th>
                            <th><?= $this->Paginator->sort('nome_completo', 'Nome Completo') ?></th>
                            <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                            <th><?= $this->Paginator->sort('cpf', 'CPF') ?></th>
                            <th><?= $this->Paginator->sort('rg', 'RG') ?></th>
                            <th><?= $this->Paginator->sort('nis', 'NIS') ?></th>
                            <th><?= $this->Paginator->sort('data_nascimento', 'Data Nascimento') ?></th>
                            <th><?= $this->Paginator->sort('telefone', 'Telefone') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Criado em') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modificado em') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr>
                            <td><?= $this->Number->format($aluno->id) ?></td>
                            <td><?= $aluno->hasValue('user') ? '<span class="badge bg-primary text-white">' . $this->Html->link($aluno->user->name, ['controller' => 'Users', 'action' => 'view', $aluno->user->id], ['class' => 'text-white', 'style' => 'text-decoration: none;']) . '</span>' : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?></td>
                            <td><?= h($aluno->nome_completo) ?></td>
                            <td><?= h($aluno->email) ?></td>
                            <td><?= h($aluno->cpf) ?></td>
                            <td><?= h($aluno->rg) ?></td>
                            <td><?= h($aluno->nis) ?></td>
                            <td><?= $aluno->data_nascimento ? $aluno->data_nascimento->format('d/m/Y') : '-' ?></td>
                            <td><?= h($aluno->telefone) ?></td>
                            <td><?= $aluno->created ? $aluno->created->format('d/m/Y H:i') : '-' ?></td>
                            <td><?= $aluno->modified ? $aluno->modified->format('d/m/Y H:i') : '-' ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['action' => 'view', $aluno->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['action' => 'delete', $aluno->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'confirm' => __('Tem certeza que deseja excluir o aluno #{0}?', $aluno->id),
                                ]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="paginator mt-3">
                <ul class="pagination">
                    <?= $this->Paginator->first('<i class="bi bi-chevron-double-left"></i> ' . __('primeira'), ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="bi bi-chevron-left"></i> ' . __('anterior'), ['escape' => false]) ?>
                    <?= $this->Paginator->numbers(['separator' => '']) ?>
                    <?= $this->Paginator->next(__('próxima') . ' <i class="bi bi-chevron-right"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->last(__('última') . ' <i class="bi bi-chevron-double-right"></i>', ['escape' => false]) ?>
                </ul>
                <p class="mt-2"><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} no total')) ?></p>
            </div>
        </div>
    </div>
</div>