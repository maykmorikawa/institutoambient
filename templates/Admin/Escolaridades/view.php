<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Escolaridade $escolaridade
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Escolaridade'), ['action' => 'edit', $escolaridade->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Escolaridade'), ['action' => 'delete', $escolaridade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $escolaridade->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Escolaridades'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Escolaridade'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="escolaridades view content">
            <h3><?= h($escolaridade->nivel) ?></h3>
            <table>
                <tr>
                    <th><?= __('Aluno') ?></th>
                    <td><?= $escolaridade->hasValue('aluno') ? $this->Html->link($escolaridade->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $escolaridade->aluno->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nivel') ?></th>
                    <td><?= h($escolaridade->nivel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Serie') ?></th>
                    <td><?= h($escolaridade->serie) ?></td>
                </tr>
                <tr>
                    <th><?= __('Situacao') ?></th>
                    <td><?= h($escolaridade->situacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Curso') ?></th>
                    <td><?= h($escolaridade->curso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao') ?></th>
                    <td><?= h($escolaridade->instituicao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ano Conclusao') ?></th>
                    <td><?= h($escolaridade->ano_conclusao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($escolaridade->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($escolaridade->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($escolaridade->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>