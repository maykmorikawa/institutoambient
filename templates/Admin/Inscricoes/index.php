<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inscrico> $inscricoes
 */

$statusCores = [
    'pendente'   => 'warning', // Amarelo
    'confirmada' => 'success', // Verde
    'cancelada'  => 'danger',  // Vermelho
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
            <i class="fas fa-ticket-alt me-2"></i><?= __('Matrículas e Inscrições') ?>
        </h6>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50 me-1"></i> Nova Matrícula', ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm btn-sm', 'escape' => false]) ?>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark small text-uppercase">
                    <tr>
                        <th style="width: 50px;"><?= $this->Paginator->sort('id', 'Nº') ?></th>
                        <th style="width: 25%;"><?= $this->Paginator->sort('aluno_id', 'Aluno') ?></th>
                        <th style="width: 25%;"><?= $this->Paginator->sort('atividade_id', 'Curso / Atividade') ?></th>
                        <th><?= $this->Paginator->sort('data_inscricao', 'Data da Matrícula') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('status', 'Situação') ?></th>
                        <th class="text-center" style="width: 140px;"><?= __('Operações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($inscricoes->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                                Nenhuma inscrição localizada no sistema.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($inscricoes as $inscrico): ?>
                    <tr>
                        <td class="text-muted font-weight-bold small">#<?= $this->Number->format($inscrico->id) ?></td>
                        <td>
                            <?php if ($inscrico->hasValue('aluno')): ?>
                                <div class="font-weight-bold text-dark mb-1"><?= h($inscrico->aluno->nome_completo) ?></div>
                                <?= $this->Html->link('<i class="fas fa-user me-1"></i> Ver Perfil', ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id], ['class' => 'badge badge-light border shadow-sm text-secondary px-2', 'escape' => false]) ?>
                            <?php else: ?>
                                <span class="badge border border-secondary text-secondary bg-light"><i class="fas fa-user-slash me-1"></i> Desconhecido</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($inscrico->hasValue('atividade')): ?>
                                <div class="text-primary font-weight-bold"><?= h($inscrico->atividade->nome) ?></div>
                                <div class="small text-muted"><i class="fas fa-link"></i> Turma/Atividade</div>
                            <?php else: ?>
                                <span class="badge border border-secondary text-secondary bg-light"><i class="fas fa-unlink me-1"></i> Removida</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="text-dark font-weight-bold">
                                <?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?>
                            </div>
                            <?php if ($inscrico->hasValue('responsavel')): ?>
                                <small class="text-muted"><i class="fas fa-headset me-1"></i> Por: <?= h($inscrico->responsavel->name) ?></small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php 
                                $statusUpper = ucfirst(strtolower($inscrico->status));
                                if (isset($statusCores[strtolower($inscrico->status)])) : 
                                    $cor = $statusCores[strtolower($inscrico->status)];
                            ?>
                                <span class="badge badge-<?= $cor ?> px-3 py-2 shadow-sm"><i class="fas fa-circle me-1 small"></i><?= h($statusUpper) ?></span>
                            <?php else : ?>
                                <span class="badge badge-secondary px-3 py-2 shadow-sm"><?= h($inscrico->status) ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <?= $this->Html->link('<i class="fas fa-id-card text-secondary"></i>', ['action' => 'view', $inscrico->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Detalhes da Matrícula', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $inscrico->id], [
                                    'class' => 'btn btn-sm btn-white',
                                    'title' => 'Excluir',
                                    'escape' => false,
                                    'confirm' => __('Atenção: Tem certeza de que prentede cancelar e APAGAR do banco a inscrição #{0}?', $inscrico->id),
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
                <?= $this->Paginator->counter('Exibindo página {{page}} de {{pages}} &middot; {{current}} de {{count}} matrículas ativas listadas') ?>
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
    .table td, .table th { border-top: 1px solid #f2f4f9; padding: 1.1rem 0.75rem; }
</style>