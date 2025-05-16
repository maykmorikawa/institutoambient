<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Aluno'), ['action' => 'edit', $aluno->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Aluno'), ['action' => 'delete', $aluno->id], ['confirm' => __('Are you sure you want to delete # {0}?', $aluno->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Alunos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Aluno'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="alunos view content">
            <h3><?= h($aluno->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($aluno->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($aluno->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cpf') ?></th>
                    <td><?= h($aluno->cpf) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rg') ?></th>
                    <td><?= h($aluno->rg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nis') ?></th>
                    <td><?= h($aluno->nis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Telefone') ?></th>
                    <td><?= h($aluno->telefone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Atividade') ?></th>
                    <td><?= $aluno->hasValue('atividade') ? $this->Html->link($aluno->atividade->titulo, ['controller' => 'Atividades', 'action' => 'view', $aluno->atividade->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($aluno->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Nascimento') ?></th>
                    <td><?= h($aluno->data_nascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($aluno->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($aluno->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Enderecos') ?></h4>
                <?php if (!empty($aluno->enderecos)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Cep') ?></th>
                            <th><?= __('Logradouro') ?></th>
                            <th><?= __('Numero') ?></th>
                            <th><?= __('Complemento') ?></th>
                            <th><?= __('Bairro') ?></th>
                            <th><?= __('Cidade') ?></th>
                            <th><?= __('Estado') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($aluno->enderecos as $endereco) : ?>
                        <tr>
                            <td><?= h($endereco->id) ?></td>
                            <td><?= h($endereco->aluno_id) ?></td>
                            <td><?= h($endereco->cep) ?></td>
                            <td><?= h($endereco->logradouro) ?></td>
                            <td><?= h($endereco->numero) ?></td>
                            <td><?= h($endereco->complemento) ?></td>
                            <td><?= h($endereco->bairro) ?></td>
                            <td><?= h($endereco->cidade) ?></td>
                            <td><?= h($endereco->estado) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Enderecos', 'action' => 'view', $endereco->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Enderecos', 'action' => 'edit', $endereco->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Enderecos', 'action' => 'delete', $endereco->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $endereco->id),
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
                <h4><?= __('Related Escolaridades') ?></h4>
                <?php if (!empty($aluno->escolaridades)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Aluno Id') ?></th>
                            <th><?= __('Nivel') ?></th>
                            <th><?= __('Serie') ?></th>
                            <th><?= __('Situacao') ?></th>
                            <th><?= __('Curso') ?></th>
                            <th><?= __('Instituicao') ?></th>
                            <th><?= __('Ano Conclusao') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($aluno->escolaridades as $escolaridade) : ?>
                        <tr>
                            <td><?= h($escolaridade->id) ?></td>
                            <td><?= h($escolaridade->aluno_id) ?></td>
                            <td><?= h($escolaridade->nivel) ?></td>
                            <td><?= h($escolaridade->serie) ?></td>
                            <td><?= h($escolaridade->situacao) ?></td>
                            <td><?= h($escolaridade->curso) ?></td>
                            <td><?= h($escolaridade->instituicao) ?></td>
                            <td><?= h($escolaridade->ano_conclusao) ?></td>
                            <td><?= h($escolaridade->created) ?></td>
                            <td><?= h($escolaridade->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Escolaridades', 'action' => 'view', $escolaridade->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Escolaridades', 'action' => 'edit', $escolaridade->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Escolaridades', 'action' => 'delete', $escolaridade->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $escolaridade->id),
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
                <?php if (!empty($aluno->inscricoes)) : ?>
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
                        <?php foreach ($aluno->inscricoes as $inscrico) : ?>
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