<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $logs
 * @var array $models
 * @var array $users
 */
$this->assign('title', 'Logs do Sistema');
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="mb-0" style="font-weight:700;"><i class="fas fa-clipboard-list me-2 text-primary"></i> Logs do Sistema</h2>
    <p class="text-muted mb-0" style="font-size:.9rem;">Histórico de todas as ações realizadas no sistema</p>
  </div>
</div>

<!-- Filtros -->
<div class="card shadow-sm mb-4">
  <div class="card-body">
    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-end']) ?>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Tabela (Model)</label>
        <?= $this->Form->select('model', array_combine($models, $models), [
          'empty' => 'Todas',
          'class' => 'form-select',
          'value' => $this->request->getQuery('model'),
        ]) ?>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Ação</label>
        <?= $this->Form->select('action', [
          'insert' => 'Criação',
          'update' => 'Alteração',
          'delete' => 'Exclusão',
        ], [
          'empty' => 'Todas',
          'class' => 'form-select',
          'value' => $this->request->getQuery('action'),
        ]) ?>
      </div>
      <div class="col-md-3">
        <label class="form-label fw-semibold">Usuário</label>
        <?= $this->Form->select('user_id', $users, [
          'empty' => 'Todos',
          'class' => 'form-select',
          'value' => $this->request->getQuery('user_id'),
        ]) ?>
      </div>
      <div class="col-md-3 d-flex gap-2">
        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search me-1"></i> Filtrar</button>
        <?= $this->Html->link('<i class="fas fa-times me-1"></i> Limpar', ['action' => 'logs'], [
          'class' => 'btn btn-outline-secondary w-100',
          'escape' => false,
        ]) ?>
      </div>
    <?= $this->Form->end() ?>
  </div>
</div>

<!-- Tabela de Logs -->
<div class="card shadow-sm">
  <div class="card-body p-0">
    <table class="table table-hover mb-0" style="font-size:.875rem;">
      <thead style="background:#f8f9fa; position:sticky; top:0;">
        <tr>
          <th class="ps-3" style="width:45px;">#</th>
          <th>Data/Hora</th>
          <th>Usuário</th>
          <th>Ação</th>
          <th>Tabela</th>
          <th>ID</th>
          <th style="width:60px;"></th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($logs->toArray())): ?>
          <tr><td colspan="7" class="text-center py-4 text-muted"><i class="fas fa-inbox me-2"></i>Nenhum log encontrado.</td></tr>
        <?php else: ?>
          <?php foreach ($logs as $log): ?>
          <tr>
            <td class="ps-3 text-muted"><?= $log->id ?></td>
            <td><?= $log->created->format('d/m/Y H:i:s') ?></td>
            <td>
              <?php if ($log->user): ?>
                <span class="badge bg-light text-dark border">
                  <i class="fas fa-user me-1"></i><?= h($log->user->name ?? $log->user->email) ?>
                </span>
              <?php else: ?>
                <span class="text-muted">Sistema</span>
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
              <span class="badge bg-<?= $b[0] ?>">
                <i class="fas <?= $b[1] ?> me-1"></i><?= $b[2] ?>
              </span>
            </td>
            <td><code><?= h($log->target_model) ?></code></td>
            <td><?= h($log->target_id) ?></td>
            <td>
              <button type="button"
                class="btn btn-sm btn-outline-secondary"
                data-bs-toggle="modal"
                data-bs-target="#logModal<?= $log->id ?>">
                <i class="fas fa-eye"></i>
              </button>
            </td>
          </tr>

          <!-- Modal com os dados JSON -->
          <div class="modal fade" id="logModal<?= $log->id ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Log #<?= $log->id ?> — <?= h($log->target_model) ?> / <?= h($log->action) ?></h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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

<!-- Paginação -->
<div class="d-flex justify-content-between align-items-center mt-3">
  <p class="text-muted mb-0" style="font-size:.85rem;">
    <?= $this->Paginator->counter('Página {{page}} de {{pages}} — {{count}} registros') ?>
  </p>
  <ul class="pagination pagination-sm mb-0">
    <?= $this->Paginator->prev('<') ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('>') ?>
  </ul>
</div>
