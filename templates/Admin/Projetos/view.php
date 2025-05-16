<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= h($projeto->titulo) ?></h2>
        <div>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Editar', ['action' => 'edit', $projeto->id], ['class' => 'btn btn-outline-secondary me-2', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="bi bi-trash"></i> Excluir', ['action' => 'delete', $projeto->id], [
                'class' => 'btn btn-outline-danger',
                'escape' => false,
                'confirm' => __('Tem certeza que deseja excluir o projeto #{0}?', $projeto->id),
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold"><?= __('Detalhes do Projeto') ?></div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th><?= __('Título') ?></th>
                    <td><?= h($projeto->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($projeto->id) ?></td>
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
                    <td><?= $projeto->ublicado ? '<span class="badge bg-success text-white">Sim</span>' : '<span class="badge bg-danger text-white">Não</span>' ?></td>
                </tr>
            </table>
        </div>
    </div>

    <?php if (!empty($projeto->atividades)) : ?>
        <div class="card mb-4">
            <div class="card-header fw-bold"><?= __('Atividades Relacionadas') ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Título') ?></th>
                                <th><?= __('Descrição') ?></th>
                                <th><?= __('Publicado') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projeto->atividades as $atividade) : ?>
                            <tr>
                                <td><?= h($atividade->id) ?></td>
                                <td><?= h($atividade->titulo) ?></td>
                                <td><?= $this->Text->truncate(h($atividade->descricao), 100, ['ellipsis' => '...']) ?></td>
                                <td><?= h($atividade->publicado) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Atividades', 'action' => 'view', $atividade->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Atividades', 'action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Atividades', 'action' => 'delete', $atividade->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'escape' => false,
                                        'confirm' => __('Tem certeza que deseja excluir a atividade #{0}?', $atividade->id),
                                    ]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>