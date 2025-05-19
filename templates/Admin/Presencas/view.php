<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Presenca $presenca
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Presenca'), ['action' => 'edit', $presenca->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Presenca'), ['action' => 'delete', $presenca->id], ['confirm' => __('Are you sure you want to delete # {0}?', $presenca->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Presencas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Presenca'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="presencas view content">
            <h3><?= h($presenca->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Aula') ?></th>
                    <td><?= $presenca->hasValue('aula') ? $this->Html->link($presenca->aula->id, ['controller' => 'Aulas', 'action' => 'view', $presenca->aula->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $presenca->hasValue('aluno') ? $this->Html->link($presenca->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $presenca->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($presenca->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($presenca->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($presenca->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Presente') ?></th>
                    <td><?= $presenca->presente ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($presenca->observacoes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>