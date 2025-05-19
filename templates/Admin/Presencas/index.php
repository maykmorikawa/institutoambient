<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Presenca> $presencas
 */
?>
<div class="presencas index content">
    <?= $this->Html->link(__('New Presenca'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Presencas') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('aula_id') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('presente') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($presencas as $presenca): ?>
                <tr>
                    <td><?= $this->Number->format($presenca->id) ?></td>
                    <td><?= $presenca->hasValue('aula') ? $this->Html->link($presenca->aula->id, ['controller' => 'Aulas', 'action' => 'view', $presenca->aula->id]) : '' ?></td>
                    <td><?= $presenca->hasValue('aluno') ? $this->Html->link($presenca->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $presenca->aluno->id]) : '' ?></td>
                    <td><?= h($presenca->presente) ?></td>
                    <td><?= h($presenca->created) ?></td>
                    <td><?= h($presenca->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $presenca->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $presenca->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $presenca->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $presenca->id),
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