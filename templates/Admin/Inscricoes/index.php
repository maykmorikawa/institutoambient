<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscrico> $inscricoes
 */
?>
<div class="inscricoes index content">
    <?= $this->Html->link(__('New Inscrico'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inscricoes') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('atividade_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('responsavel_id') ?></th>
                    <th><?= $this->Paginator->sort('data_inscricao') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inscricoes as $inscrico): ?>
                <tr>
                    <td><?= $this->Number->format($inscrico->id) ?></td>
                    <td><?= $inscrico->hasValue('aluno') ? $this->Html->link($inscrico->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id]) : '' ?></td>
                    <td><?= $inscrico->hasValue('atividade') ? $this->Html->link($inscrico->atividade->titulo, ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id]) : '' ?></td>
                    <td><?= $inscrico->hasValue('user') ? $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id]) : '' ?></td>
                    <td><?= $inscrico->hasValue('responsavel') ? $this->Html->link($inscrico->responsavel->name, ['controller' => 'Users', 'action' => 'view', $inscrico->responsavel->id]) : '' ?></td>
                    <td><?= h($inscrico->data_inscricao) ?></td>
                    <td><?= h($inscrico->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inscrico->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inscrico->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $inscrico->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $inscrico->id),
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