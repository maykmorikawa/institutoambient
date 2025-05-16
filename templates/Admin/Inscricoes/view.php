<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inscrico'), ['action' => 'edit', $inscrico->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inscrico'), ['action' => 'delete', $inscrico->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inscrico->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inscrico'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inscricoes view content">
            <h3><?= h($inscrico->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $inscrico->hasValue('aluno') ? $this->Html->link($inscrico->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Atividade') ?></th>
                    <td><?= $inscrico->hasValue('atividade') ? $this->Html->link($inscrico->atividade->titulo, ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $inscrico->hasValue('user') ? $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Responsavel') ?></th>
                    <td><?= $inscrico->hasValue('responsavel') ? $this->Html->link($inscrico->responsavel->name, ['controller' => 'Users', 'action' => 'view', $inscrico->responsavel->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($inscrico->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inscrico->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Inscricao') ?></th>
                    <td><?= h($inscrico->data_inscricao) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>