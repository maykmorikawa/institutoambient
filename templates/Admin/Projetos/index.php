<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Projeto> $projetos
 */

$statusCores = [
    'planejamento' => 'info',    // Azul claro
    'andamento'    => 'warning', // Amarelo
    'concluido'    => 'success', // Verde
    'cancelado'    => 'danger',  // Vermelho
];

$this->Paginator->setTemplates([
    'nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}">{{text}}</a></li>',
    'nextDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>',
    'prevDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
    'counterRange' => '{{start}} - {{end}} of {{count}}',
    'counterPages' => '{{page}} of {{pages}}',
    'first' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'last' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
    'current' => '<li class="page-item active"><span class="page-link">{{text}}</span></li>',
    'ellipsis' => '<li class="page-item disabled"><span class="page-link">...</span></li>',
]);
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-project-diagram me-2"></i><?= __('Projetos Ativos') ?>
        </h6>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50 me-1"></i> ' . __('Novo Projeto'), ['action' => 'add'], ['class' => 'btn btn-sm btn-primary shadow-sm', 'escape' => false]) ?>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark small text-uppercase">
                    <tr>
                        <th style="width: 50px;"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th style="width: 30%;"><?= $this->Paginator->sort('name', 'Nome do Projeto') ?></th>
                        <th><?= $this->Paginator->sort('status', 'Monitoramento') ?></th>
                        <th><?= $this->Paginator->sort('data_inicio', 'Duração (Prazos)') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('publicado', 'Visibilidade') ?></th>
                        <th class="text-center" style="width: 140px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($projetos->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-project-diagram fa-3x mb-3 d-block text-gray-300"></i>
                                Nenhum projeto encontrado. Construa o seu primeiro!
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($projetos as $projeto): ?>
                    <tr>
                        <td class="text-muted font-weight-bold small">#<?= $this->Number->format($projeto->id) ?></td>
                        <td>
                            <div class="font-weight-bold text-primary mb-1"><?= h($projeto->name) ?></div>
                            <?php if ($projeto->hasValue('user')): ?>
                                <small class="text-muted"><i class="fas fa-user-circle me-1"></i> Coord: <?= h($projeto->user->name) ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (isset($statusCores[$projeto->status])) : ?>
                                <span class="badge badge-<?= $statusCores[$projeto->status] ?> p-2 shadow-sm text-uppercase" style="letter-spacing: 0.05em;"><i class="fas fa-dot-circle me-1 small"></i><?= h($projeto->status) ?></span>
                            <?php else : ?>
                                <span class="badge badge-secondary p-2"><?= h($projeto->status) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="small">
                            <div><i class="fas fa-hourglass-start text-success me-1"></i> <span class="text-dark">Início:</span> <?= $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' ?></div>
                            <div class="mt-1"><i class="fas fa-hourglass-end text-danger me-1"></i> <span class="text-dark">Fim:</span> <?= $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '<span class="text-muted">Aberto</span>' ?></div>
                        </td>
                        <td class="text-center">
                            <?php if ($projeto->publicado): ?>
                                <span class="badge bg-success text-white shadow-sm px-2"><i class="fas fa-eye me-1"></i>Público</span>
                            <?php else: ?>
                                <span class="badge border border-danger text-danger bg-white shadow-sm px-2"><i class="fas fa-eye-slash me-1"></i>Oculto</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['action' => 'view', $projeto->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Visualizar Projeto', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $projeto->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar Projeto', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $projeto->id], [
                                    'class' => 'btn btn-sm btn-white',
                                    'title' => 'Excluir',
                                    'escape' => false,
                                    'confirm' => __('A exclusão do projeto #{0} é PERMANENTE. Continuar?', $projeto->id),
                                ]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 small text-muted">
                <?= $this->Paginator->counter('Visualizando página {{page}} de {{pages}} &middot; {{current}} resultados em tela') ?>
            </div>
            <nav aria-label="Navegação">
                <ul class="pagination pagination-sm mb-0 shadow-sm">
                    <?= $this->Paginator->first('<i class="fas fa-angle-double-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->prev('<i class="fas fa-angle-left"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->numbers(['class' => 'page-item', 'linkClass' => 'page-link']) ?>
                    <?= $this->Paginator->next('<i class="fas fa-angle-right"></i>', ['escape' => false]) ?>
                    <?= $this->Paginator->last('<i class="fas fa-angle-double-right"></i>', ['escape' => false]) ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    .btn-white { background: #fff; border: 1px solid #e3e6f0; }
    .btn-white:hover { background: #f8f9fc; border-color: #d1d3e2; }
    .table td, .table th { border-top: 1px solid #f2f4f9; padding: 1rem 0.75rem; }
</style>