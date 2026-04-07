<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $logs
 * @var array $models
 * @var array $users
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

$this->assign('title', 'Logs do Sistema');
?>

<div class="card shadow mb-4">
    <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-clipboard-list me-2"></i><?= __('Logs do Sistema') ?>
        </h6>
        <small class="text-muted">Histórico de todas as ações realizadas no sistema</small>
    </div>
    
    <div class="card-body">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-end']) ?>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-muted text-uppercase">Tabela (Model)</label>
            <?= $this->Form->select('model', array_combine($models, $models), [
                'empty' => 'Todas',
                'class' => 'form-select form-select-sm',
                'value' => $this->request->getQuery('model'),
            ]) ?>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-muted text-uppercase">Ação</label>
            <?= $this->Form->select('action', [
                'insert' => 'Criação',
                'update' => 'Alteração',
                'delete' => 'Exclusão',
            ], [
                'empty' => 'Todas',
                'class' => 'form-select form-select-sm',
                'value' => $this->request->getQuery('action'),
            ]) ?>
        </div>
        <div class="col-md-3">
            <label class="form-label small fw-semibold text-muted text-uppercase">Usuário</label>
            <?= $this->Form->select('user_id', $users, [
                'empty' => 'Todos',
                'class' => 'form-select form-select-sm',
                'value' => $this->request->getQuery('user_id'),
            ]) ?>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm shadow-sm"><i class="fas fa-search me-1"></i> Filtrar</button>
            <?= $this->Html->link('<i class="fas fa-times me-1"></i> Limpar', ['action' => 'logs'], [
                'class' => 'btn btn-outline-secondary btn-sm shadow-sm',
                'escape' => false,
            ]) ?>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" style="font-size: .875rem;">
                <thead class="bg-light text-dark small text-uppercase">
                    <tr>
                        <th class="px-4" style="width: 50px;">#</th>
                        <th><?= $this->Paginator->sort('created', 'Data/Hora') ?></th>
                        <th>Usuário</th>
                        <th><?= $this->Paginator->sort('action', 'Ação') ?></th>
                        <th>Tabela</th>
                        <th>ID</th>
                        <th>IP</th>
                        <th style="width: 60px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($logs->toArray())): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 d-block text-gray-300"></i>
                                Nenhum log encontrado.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td class="text-muted font-weight-bold small px-4">#<?= $log->id ?></td>
                            <td>
                                <div class="text-dark"><?= $log->created->format('d/m/Y') ?></div>
                                <small class="text-muted"><?= $log->created->format('H:i:s') ?></small>
                            </td>
                            <td>
                                <?php if ($log->user): ?>
                                    <span class="badge border border-primary text-primary bg-white shadow-sm px-2 py-1">
                                        <i class="fas fa-user me-1"></i><?= h($log->user->name ?? $log->user->email) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-light text-muted border shadow-sm px-2 py-1">
                                        <i class="fas fa-robot me-1"></i>Sistema
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php
                                    $badges = [
                                        'insert' => ['success', 'fa-plus-circle',  'Criação'],
                                        'update' => ['warning',  'fa-edit',         'Alteração'],
                                        'delete' => ['danger',   'fa-trash',        'Exclusão'],
                                    ];
                                    $b = $badges[$log->action] ?? ['secondary', 'fa-question', $log->action];
                                ?>
                                <span class="badge bg-<?= $b[0] ?> shadow-sm">
                                    <i class="fas <?= $b[1] ?> me-1"></i><?= $b[2] ?>
                                </span>
                            </td>
                            <td><code class="bg-light px-2 py-1 rounded small"><?= h($log->target_model) ?></code></td>
                            <td class="text-muted"><?= h($log->target_id) ?></td>
                            <td class="text-muted small"><?= h($log->ip_address) ?></td>
                            <td>
                                <button type="button"
                                    class="btn btn-sm btn-white shadow-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#logModal<?= $log->id ?>"
                                    title="Ver detalhes">
                                    <i class="fas fa-eye text-secondary"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="logModal<?= $log->id ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            <i class="fas fa-clipboard-list me-2"></i>
                                            Log #<?= $log->id ?> — <?= h($log->target_model) ?> / <?= h($log->action) ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <small class="text-muted fw-bold text-uppercase">Usuário:</small><br>
                                            <span class="text-dark"><?= $log->user ? h($log->user->name ?? $log->user->email) : 'Sistema' ?></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted fw-bold text-uppercase">Data/Hora:</small><br>
                                            <span class="text-dark"><?= $log->created->format('d/m/Y H:i:s') ?></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted fw-bold text-uppercase">IP:</small><br>
                                            <span class="text-dark"><?= h($log->ip_address) ?></span>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted fw-bold text-uppercase">Dispositivo/Browser:</small><br>
                                            <small class="text-secondary"><?= h($log->user_agent) ?></small>
                                        </div>
                                        <hr>
                                        <small class="text-muted fw-bold text-uppercase d-block mb-2">Alterações (JSON):</small>
                                        <pre style="background:#1e1e1e; color:#d4d4d4; border-radius:8px; padding:1rem; max-height:400px; overflow-y:auto; font-size:.8rem;"><?= h(json_encode(json_decode($log->data_changes), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="card-footer bg-white border-top-0 pt-3 pb-3">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="mb-3 mb-md-0 small text-muted px-2">
                <?= $this->Paginator->counter('Exibindo página {{page}} de {{pages}} &middot; Total de registros: {{count}}') ?>
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
    code { background: #f8f9fa; }
</style>