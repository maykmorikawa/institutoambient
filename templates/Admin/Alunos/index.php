<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Aluno> $alunos
 */

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
            <i class="fas fa-users me-2"></i><?= __('Diretório de Alunos / Cidadãos') ?>
        </h6>
        <?= $this->Html->link('<i class="fas fa-user-plus fa-sm text-white-50 me-1"></i> Cadastrar Aluno', ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm btn-sm', 'escape' => false]) ?>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark small text-uppercase">
                    <tr>
                        <th class="px-4" style="width: 50px;"><?= $this->Paginator->sort('id', 'Nº') ?></th>
                        <th><?= $this->Paginator->sort('nome_completo', 'Nome Completo e Documento') ?></th>
                        <th><?= $this->Paginator->sort('telefone', 'Contato Rápido') ?></th>
                        <th><?= $this->Paginator->sort('data_nascimento', 'Idade / Nascimento') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('user_id', 'Acesso Web') ?></th>
                        <th class="text-center" style="width: 140px;"><?= __('Operações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($alunos->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-users-slash fa-3x mb-3 d-block text-gray-300"></i>
                                Nenhum cidadão cadastrado ainda na base de dados.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td class="text-muted font-weight-bold small px-4">#<?= $this->Number->format($aluno->id) ?></td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm mr-3" style="width: 40px; height: 40px; font-size: 1.1rem; flex-shrink: 0;">
                                    <?= mb_substr(h($aluno->nome_completo), 0, 1) ?>
                                </div>
                                <div>
                                    <div class="font-weight-bold text-dark border-bottom pb-1 mb-1" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= h($aluno->nome_completo) ?>">
                                        <?= h($aluno->nome_completo) ?>
                                    </div>
                                    <small class="text-muted"><i class="fas fa-id-badge text-gray-400 mr-1"></i> CPF: <?= h($aluno->cpf) ?: '<span class="text-warning">Não Informado</span>' ?></small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark"><i class="fas fa-phone-alt text-success me-1"></i> <?= h($aluno->telefone) ?: '-' ?></div>
                            <small class="text-muted" style="max-width: 180px; display:inline-block; overflow: hidden; text-overflow: ellipsis;"><i class="fas fa-envelope text-gray-400 me-1"></i><?= h($aluno->email) ?: 'S/ Email' ?></small>
                        </td>
                        <td>
                            <div class="text-dark">
                                <?= $aluno->data_nascimento ? $aluno->data_nascimento->format('d/m/Y') : '<span class="text-muted">-</span>' ?>
                            </div>
                            <?php if ($aluno->data_nascimento): 
                                $idade = date_diff(date_create($aluno->data_nascimento->format('Y-m-d')), date_create('now'))->y;
                            ?>
                                <small class="text-info"><?= $idade ?> anos</small>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if ($aluno->hasValue('user')): ?>
                                <span class="badge border border-success text-success bg-white shadow-sm px-2 py-1" title="Tem conta no Portal"><i class="fas fa-check-circle me-1"></i>Vinculado</span>
                            <?php else: ?>
                                <span class="badge border border-secondary text-secondary bg-light shadow-sm px-2 py-1"><i class="fas fa-times-circle me-1"></i>Sem Conta</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group shadow-sm">
                                <?= $this->Html->link('<i class="fas fa-user-circle text-secondary"></i>', ['action' => 'view', $aluno->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Ver Dossiê', 'escape' => false]) ?>
                                <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $aluno->id], [
                                    'class' => 'btn btn-sm btn-white',
                                    'title' => 'Excluir Cidadão',
                                    'escape' => false,
                                    'confirm' => __('PERIGO: Se você excluir {0}, todas as matrículas, inscrições e presenças dele SUMIRÃO da base de dados. Confirmar?', $aluno->nome_completo),
                                ]) ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-top-0 pt-3 pb-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0 small text-muted px-2">
                <?= $this->Paginator->counter('Exibindo página {{page}} de {{pages}} &middot; Cidadãos listados: {{current}} de {{count}}') ?>
            </div>
            <nav aria-label="Navegação px-2">
                <ul class="pagination pagination-sm mb-0 shadow-sm pr-3">
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
    .table td, .table th { border-top: 1px solid #f2f4f9; padding: 1.25rem 0.75rem; }
</style>