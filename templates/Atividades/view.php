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
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($atividade->titulo) ?></td>
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
                <h4><?= __('Related Alunos') ?></h4>
                <?php if (!empty($atividade->alunos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Atividade Id') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Cpf') ?></th>
                            <th><?= __('Rg') ?></th>
                            <th><?= __('Nis') ?></th>
                            <th><?= __('Data Nascimento') ?></th>
                            <th><?= __('Telefone') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($atividade->alunos as $aluno) : ?>
                        <tr>
                            <td><?= h($aluno->id) ?></td>
                            <td><?= h($aluno->atividade_id) ?></td>
                            <td><?= h($aluno->nome) ?></td>
                            <td><?= h($aluno->email) ?></td>
                            <td><?= h($aluno->cpf) ?></td>
                            <td><?= h($aluno->rg) ?></td>
                            <td><?= h($aluno->nis) ?></td>
                            <td><?= h($aluno->data_nascimento) ?></td>
                            <td><?= h($aluno->telefone) ?></td>
                            <td><?= h($aluno->created) ?></td>
                            <td><?= h($aluno->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Alunos', 'action' => 'view', $aluno->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Alunos', 'action' => 'delete', $aluno->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $aluno->id),
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