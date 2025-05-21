<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Aluno> $alunos
 */
?>
<div class="alunos index content">
    <?= $this->Html->link(__('New Aluno'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Alunos') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('nome_completo') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('cpf') ?></th>
                    <th><?= $this->Paginator->sort('rg') ?></th>
                    <th><?= $this->Paginator->sort('nis') ?></th>
                    <th><?= $this->Paginator->sort('data_nascimento') ?></th>
                    <th><?= $this->Paginator->sort('telefone') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $aluno): ?>
                <tr>
                    <td><?= $this->Number->format($aluno->id) ?></td>
                    <td><?= $aluno->hasValue('user') ? $this->Html->link($aluno->user->name, ['controller' => 'Users', 'action' => 'view', $aluno->user->id]) : '' ?></td>
                    <td><?= h($aluno->nome_completo) ?></td>
                    <td><?= h($aluno->email) ?></td>
                    <td><?= h($aluno->cpf) ?></td>
                    <td><?= h($aluno->rg) ?></td>
                    <td><?= h($aluno->nis) ?></td>
                    <td><?= h($aluno->data_nascimento) ?></td>
                    <td><?= h($aluno->telefone) ?></td>
                    <td><?= h($aluno->created) ?></td>
                    <td><?= h($aluno->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $aluno->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $aluno->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $aluno->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $aluno->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>