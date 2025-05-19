<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 */
?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= h($projeto->name) ?></h3>
                <div>
                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $projeto->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                        ['action' => 'delete', $projeto->id],
                        ['confirm' => __('Tem certeza que deseja excluir o projeto #{0}?', $projeto->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]
                    ) ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><?= __('Nome') ?></th>
                        <td><?= h($projeto->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><?= h($projeto->status) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Usuário') ?></th>
                        <td><?= $projeto->hasValue('user') ? $this->Html->link($projeto->user->name, ['controller' => 'Users', 'action' => 'view', $projeto->user->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><?= $this->Number->format($projeto->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data Início') ?></th>
                        <td><?= $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data Fim') ?></th>
                        <td><?= $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Criado em') ?></th>
                        <td><?= $projeto->created ? $projeto->created->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modificado em') ?></th>
                        <td><?= $projeto->modified ? $projeto->modified->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Publicado') ?></th>
                        <td><?= $projeto->publicado ? '<span class="badge bg-success text-white">Sim</span>' : '<span class="badge bg-danger text-white">Não</span>' ?></td>
                    </tr>
                </table>
                <div class="text mt-3">
                    <strong><?= __('Descrição') ?></strong>
                    <blockquote>
                        <?= $this->Text->autoParagraph(h($projeto->descricao)); ?>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="related mt-4">
            <h4><?= __('Atividades Relacionadas') ?></h4>
            <?php if (!empty($projeto->atividades)) : ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th><?= __('ID') ?></th>
                            <th><?= __('Projeto ID') ?></th>
                            <th><?= __('Nome') ?></th>
                            <th><?= __('Descrição') ?></th>
                            <th><?= __('Vagas') ?></th>
                            <th><?= __('Local') ?></th>
                            <th><?= __('Horário') ?></th>
                            <th><?= __('Dias Semana') ?></th>
                            <th><?= __('Usuário ID') ?></th>
                            <th><?= __('Slug') ?></th>
                            <th><?= __('Link Inscrição') ?></th>
                            <th><?= __('Publicado') ?></th>
                            <th><?= __('Criado em') ?></th>
                            <th><?= __('Modificado em') ?></th>
                            <th class="actions"><?= __('Ações') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projeto->atividades as $atividade) : ?>
                        <tr>
                            <td><?= h($atividade->id) ?></td>
                            <td><?= h($atividade->projeto_id) ?></td>
                            <td><?= h($atividade->name) ?></td>
                            <td><?= h($atividade->descricao) ?></td>
                            <td><?= $this->Number->format($atividade->vagas) ?></td>
                            <td><?= h($atividade->local) ?></td>
                            <td><?= h($atividade->horario) ?></td>
                            <td><?= h($atividade->dias_semana) ?></td>
                            <td><?= $atividade->hasValue('user') ? $this->Html->link($atividade->user->name, ['controller' => 'Users', 'action' => 'view', $atividade->user->id]) : '' ?></td>
                            <td><?= h($atividade->slug) ?></td>
                            <td><?= h($atividade->link_inscricao) ?></td>
                            <td><?= $atividade->publicado ? __('Sim') : __('Não'); ?></td>
                            <td><?= $atividade->created ? $atividade->created->format('d/m/Y H:i') : '-' ?></td>
                            <td><?= $atividade->modified ? $atividade->modified->format('d/m/Y H:i') : '-' ?></td>
                            <td class="actions">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Atividades', 'action' => 'view', $atividade->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Atividades', 'action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Atividades', 'action' => 'delete', $atividade->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $atividade->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-3">
            <?= $this->Html->link('<i class="bi bi-arrow-left-square-fill"></i> ' . __('Listar Projetos'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="bi bi-plus-square-fill"></i> ' . __('Novo Projeto'), ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false, 'style' => 'margin-left: 10px;']) ?>
        </div>
    </div>
</div>