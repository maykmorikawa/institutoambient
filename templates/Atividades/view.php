<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Atividade'), ['action' => 'edit', $atividade->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Atividade'), ['action' => 'delete', $atividade->id], ['confirm' => __('Are you sure you want to delete # {0}?', $atividade->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Atividades'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Atividade'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="atividades view content">
            <h3><?= h($atividade->titulo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Projeto') ?></th>
                    <td><?= $atividade->hasValue('projeto') ? $this->Html->link($atividade->projeto->titulo, ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($atividade->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Local') ?></th>
                    <td><?= h($atividade->local) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dias Semana') ?></th>
                    <td><?= h($atividade->dias_semana) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $atividade->hasValue('user') ? $this->Html->link($atividade->user->name, ['controller' => 'Users', 'action' => 'view', $atividade->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($atividade->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Link Inscricao') ?></th>
                    <td><?= h($atividade->link_inscricao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($atividade->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vagas') ?></th>
                    <td><?= $this->Number->format($atividade->vagas) ?></td>
                </tr>
                <tr>
                    <th><?= __('Horario') ?></th>
                    <td><?= h($atividade->horario) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($atividade->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($atividade->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publicado') ?></th>
                    <td><?= $atividade->publicado ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($atividade->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Aulas') ?></h4>
                <?php if (!empty($atividade->aulas)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Atividade Id') ?></th>
                            <th><?= __('Data') ?></th>
                            <th><?= __('Conteudo') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($atividade->aulas as $aula) : ?>
                        <tr>
                            <td><?= h($aula->id) ?></td>
                            <td><?= h($aula->atividade_id) ?></td>
                            <td><?= h($aula->data) ?></td>
                            <td><?= h($aula->conteudo) ?></td>
                            <td><?= h($aula->observacoes) ?></td>
                            <td><?= h($aula->created) ?></td>
                            <td><?= h($aula->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Aulas', 'action' => 'view', $aula->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Aulas', 'action' => 'edit', $aula->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Aulas', 'action' => 'delete', $aula->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $aula->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Inscricoes') ?></h4>
                <?php if (!empty($atividade->inscricoes)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Atividade Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Responsavel Id') ?></th>
                            <th><?= __('Data Inscricao') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($atividade->inscricoes as $inscrico) : ?>
                        <tr>
                            <td><?= h($inscrico->id) ?></td>
                            <td><?= h($inscrico->aluno_id) ?></td>
                            <td><?= h($inscrico->atividade_id) ?></td>
                            <td><?= h($inscrico->user_id) ?></td>
                            <td><?= h($inscrico->responsavel_id) ?></td>
                            <td><?= h($inscrico->data_inscricao) ?></td>
                            <td><?= h($inscrico->status) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Inscricoes', 'action' => 'view', $inscrico->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscrico->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Inscricoes', 'action' => 'delete', $inscrico->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $inscrico->id),
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