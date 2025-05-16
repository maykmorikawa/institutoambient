<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Student> $students
 */
?>
<div class="students index content">
    <?= $this->Html->link(__('New Student'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Students') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('data_nascimento') ?></th>
                    <th><?= $this->Paginator->sort('genero') ?></th>
                    <th><?= $this->Paginator->sort('estado_civil') ?></th>
                    <th><?= $this->Paginator->sort('religiao') ?></th>
                    <th><?= $this->Paginator->sort('naturalidade') ?></th>
                    <th><?= $this->Paginator->sort('cor_etnia') ?></th>
                    <th><?= $this->Paginator->sort('rg') ?></th>
                    <th><?= $this->Paginator->sort('nis') ?></th>
                    <th><?= $this->Paginator->sort('valor_beneficio') ?></th>
                    <th><?= $this->Paginator->sort('cadunico_codigo') ?></th>
                    <th><?= $this->Paginator->sort('cep') ?></th>
                    <th><?= $this->Paginator->sort('endereco') ?></th>
                    <th><?= $this->Paginator->sort('municipio') ?></th>
                    <th><?= $this->Paginator->sort('pessoa_com_deficiencia') ?></th>
                    <th><?= $this->Paginator->sort('tipo_deficiencia') ?></th>
                    <th><?= $this->Paginator->sort('serie_estudada') ?></th>
                    <th><?= $this->Paginator->sort('situacao_escolar') ?></th>
                    <th><?= $this->Paginator->sort('instituicao_ensino') ?></th>
                    <th><?= $this->Paginator->sort('turma') ?></th>
                    <th><?= $this->Paginator->sort('autorizo_imagem') ?></th>
                    <th><?= $this->Paginator->sort('compromisso_social') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?= $this->Number->format($student->id) ?></td>
                    <td><?= $student->hasValue('user') ? $this->Html->link($student->user->name, ['controller' => 'Users', 'action' => 'view', $student->user->id]) : '' ?></td>
                    <td><?= h($student->data_nascimento) ?></td>
                    <td><?= h($student->genero) ?></td>
                    <td><?= h($student->estado_civil) ?></td>
                    <td><?= h($student->religiao) ?></td>
                    <td><?= h($student->naturalidade) ?></td>
                    <td><?= h($student->cor_etnia) ?></td>
                    <td><?= h($student->rg) ?></td>
                    <td><?= h($student->nis) ?></td>
                    <td><?= h($student->valor_beneficio) ?></td>
                    <td><?= h($student->cadunico_codigo) ?></td>
                    <td><?= h($student->cep) ?></td>
                    <td><?= h($student->endereco) ?></td>
                    <td><?= h($student->municipio) ?></td>
                    <td><?= h($student->pessoa_com_deficiencia) ?></td>
                    <td><?= h($student->tipo_deficiencia) ?></td>
                    <td><?= h($student->serie_estudada) ?></td>
                    <td><?= h($student->situacao_escolar) ?></td>
                    <td><?= h($student->instituicao_ensino) ?></td>
                    <td><?= h($student->turma) ?></td>
                    <td><?= h($student->autorizo_imagem) ?></td>
                    <td><?= h($student->compromisso_social) ?></td>
                    <td><?= h($student->created) ?></td>
                    <td><?= h($student->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $student->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $student->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $student->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $student->id),
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