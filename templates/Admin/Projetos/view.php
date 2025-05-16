<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Projeto'), ['action' => 'edit', $projeto->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Projeto'), ['action' => 'delete', $projeto->id], ['confirm' => __('Are you sure you want to delete # {0}?', $projeto->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Projetos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Projeto'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="projetos view content">
            <h3><?= h($projeto->titulo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($projeto->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($projeto->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($projeto->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($projeto->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ublicado') ?></th>
                    <td><?= $projeto->ublicado ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Atividades') ?></h4>
                <?php if (!empty($projeto->atividades)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Projeto Id') ?></th>
                            <th><?= __('Titulo') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Link Inscricao') ?></th>
                            <th><?= __('Publicado') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($projeto->atividades as $atividade) : ?>
                        <tr>
                            <td><?= h($atividade->id) ?></td>
                            <td><?= h($atividade->projeto_id) ?></td>
                            <td><?= h($atividade->titulo) ?></td>
                            <td><?= h($atividade->descricao) ?></td>
                            <td><?= h($atividade->slug) ?></td>
                            <td><?= h($atividade->link_inscricao) ?></td>
                            <td><?= h($atividade->publicado) ?></td>
                            <td><?= h($atividade->created) ?></td>
                            <td><?= h($atividade->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Atividades', 'action' => 'view', $atividade->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Atividades', 'action' => 'edit', $atividade->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Atividades', 'action' => 'delete', $atividade->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $atividade->id),
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