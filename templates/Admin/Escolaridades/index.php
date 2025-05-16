<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Escolaridade> $escolaridades
 */
?>
<div class="escolaridades index content">
    <?= $this->Html->link(__('New Escolaridade'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Escolaridades') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('aluno_id') ?></th>
                    <th><?= $this->Paginator->sort('nivel') ?></th>
                    <th><?= $this->Paginator->sort('serie') ?></th>
                    <th><?= $this->Paginator->sort('situacao') ?></th>
                    <th><?= $this->Paginator->sort('curso') ?></th>
                    <th><?= $this->Paginator->sort('instituicao') ?></th>
                    <th><?= $this->Paginator->sort('ano_conclusao') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($escolaridades as $escolaridade): ?>
                <tr>
                    <td><?= $this->Number->format($escolaridade->id) ?></td>
                    <td><?= $escolaridade->hasValue('aluno') ? $this->Html->link($escolaridade->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $escolaridade->aluno->id]) : '' ?></td>
                    <td><?= h($escolaridade->nivel) ?></td>
                    <td><?= h($escolaridade->serie) ?></td>
                    <td><?= h($escolaridade->situacao) ?></td>
                    <td><?= h($escolaridade->curso) ?></td>
                    <td><?= h($escolaridade->instituicao) ?></td>
                    <td><?= h($escolaridade->ano_conclusao) ?></td>
                    <td><?= h($escolaridade->created) ?></td>
                    <td><?= h($escolaridade->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $escolaridade->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $escolaridade->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $escolaridade->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $escolaridade->id),
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