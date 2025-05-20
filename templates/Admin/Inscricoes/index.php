<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscrico> $inscricoes
 */
?>
<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0"><?= __('Inscrições') ?></h3>
            <?= $this->Html->link('<i class="bi bi-plus-square"></i> ' . __('Nova Inscrição'), ['action' => 'add'], ['class' => 'btn btn-primary', 'escape' => false]) ?>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', '#') ?></th>
                            <th><?= $this->Paginator->sort('aluno_id', 'Aluno') ?></th>
                            <th><?= $this->Paginator->sort('atividade_id', 'Atividade') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Usuário') ?></th>
                            <th><?= $this->Paginator->sort('responsavel_id', 'Responsável') ?></th>
                            <th><?= $this->Paginator->sort('data_inscricao', 'Data Inscrição') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscricoes as $inscrico): ?>
                        <tr>
                            <td><?= $this->Number->format($inscrico->id) ?></td>
                            <td><?= $inscrico->hasValue('aluno') ? '<span class="badge bg-info text-white">' . $this->Html->link($inscrico->aluno->nome_completo, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id], ['class' => 'text-white', 'style' => 'text-decoration: none;']) . '</span>' : '<span class="badge bg-secondary text-white">' . __('Sem Aluno') . '</span>' ?></td>
                            <td><?= $inscrico->hasValue('atividade') ? '<span class="badge bg-warning text-dark">' . $this->Html->link($inscrico->atividade->nome, ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id], ['class' => 'text-dark', 'style' => 'text-decoration: none;']) . '</span>' : '<span class="badge bg-secondary text-white">' . __('Sem Atividade') . '</span>' ?></td>
                            <td><?= $inscrico->hasValue('user') ? '<span class="badge bg-primary text-white">' . $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id], ['class' => 'text-white', 'style' => 'text-decoration: none;']) . '</span>' : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?></td>
                            <td><?= $inscrico->hasValue('responsavel') ? '<span class="badge bg-success text-white">' . $this->Html->link($inscrico->responsavel->name, ['controller' => 'Users', 'action' => 'view', $inscrico->responsavel->id], ['class' => 'text-white', 'style' => 'text-decoration: none;']) . '</span>' : '<span class="badge bg-secondary text-white">' . __('Sem Responsável') . '</span>' ?></td>
                            <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?></td>
                            <td><?= h($inscrico->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['action' => 'view', $inscrico->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['action' => 'delete', $inscrico->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'escape' => false,
                                    'confirm' => __('Tem certeza que deseja excluir a inscrição #{0}?', $inscrico->id),
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