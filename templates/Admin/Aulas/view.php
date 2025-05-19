<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Aula'), ['action' => 'edit', $aula->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Aula'), ['action' => 'delete', $aula->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aula->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Aulas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Aula'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="aulas view content">
            <h3><?= h($aula->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Atividade') ?></th>
                    <td><?= $aula->hasValue('atividade') ? $this->Html->link($aula->atividade->titulo, ['controller' => 'Atividades', 'action' => 'view', $aula->atividade->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($aula->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data') ?></th>
                    <td><?= h($aula->data) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($aula->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($aula->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Conteudo') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($aula->conteudo)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($aula->observacoes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Presencas') ?></h4>
                <?php if (!empty($aula->presencas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aula Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Presente') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($aula->presencas as $presenca) : ?>
                        <tr>
                            <td><?= h($presenca->id) ?></td>
                            <td><?= h($presenca->aula_id) ?></td>
                            <td><?= h($presenca->aluno_id) ?></td>
                            <td><?= h($presenca->presente) ?></td>
                            <td><?= h($presenca->observacoes) ?></td>
                            <td><?= h($presenca->created) ?></td>
                            <td><?= h($presenca->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Presencas', 'action' => 'view', $presenca->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Presencas', 'action' => 'edit', $presenca->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Presencas', 'action' => 'delete', $presenca->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $presenca->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>