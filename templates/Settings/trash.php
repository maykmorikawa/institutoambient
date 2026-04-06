<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $trashItems
 * @var array $tables
 * @var string $tableFilter
 */
$this->assign('title', 'Lixeira');

$tableLabels = [
    'Posts'      => 'Postagens',
    'Users'      => 'Usuários',
    'Alunos'     => 'Alunos',
    'Projetos'   => 'Projetos',
    'Atividades' => 'Atividades',
    'Inscricoes' => 'Inscrições',
    'Categories' => 'Categorias',
    'Tags'       => 'Tags',
];
?>

<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h2 class="mb-0" style="font-weight:700;"><i class="fas fa-trash-restore me-2 text-danger"></i> Lixeira</h2>
    <p class="text-muted mb-0" style="font-size:.9rem;">Registros excluídos (soft delete) — selecione uma tabela para visualizar</p>
  </div>
</div>

<!-- Abas de Tabelas -->
<div class="card shadow-sm mb-4">
  <div class="card-body p-0">
    <div class="d-flex flex-wrap gap-1 p-3" style="border-bottom:1px solid #eee;">
      <?php foreach ($tables as $t): ?>
        <?= $this->Html->link(
          $tableLabels[$t] ?? $t,
          ['action' => 'trash', '?' => ['table' => $t]],
          [
            'class' => 'btn btn-sm ' . ($tableFilter === $t ? 'btn-primary' : 'btn-outline-secondary'),
          ]
        ) ?>
      <?php endforeach; ?>
    </div>

    <?php if (empty($trashItems) || count($trashItems->toArray()) === 0): ?>
      <div class="text-center py-5 text-muted">
        <i class="fas fa-check-circle fa-3x mb-3" style="color:#d0e8d0;"></i>
        <p>Nenhum registro excluído em <strong><?= h($tableLabels[$tableFilter] ?? $tableFilter) ?></strong>.</p>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:.875rem;">
          <thead style="background:#fff8f8;">
            <tr>
              <th class="ps-3" style="width:60px;">ID</th>
              <th>Resumo do Registro</th>
              <th>Excluído em</th>
              <th style="width:120px;" class="text-end pe-3">Ação</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($trashItems as $item): ?>
            <tr>
              <td class="ps-3 text-muted"><?= $item->id ?></td>
              <td>
                <code class="text-muted" style="font-size:.78rem;">
                  <?php
                    $arr = $item->toArray();
                    unset($arr['deleted_at'], $arr['password']);
                    $preview = array_slice($arr, 0, 3, true);
                    foreach ($preview as $k => $v) {
                        echo h($k) . ': <strong>' . h(is_string($v) ? $v : json_encode($v)) . '</strong> &nbsp;';
                    }
                  ?>
                </code>
              </td>
              <td>
              <span class="text-danger">
                  <i class="fas fa-clock me-1"></i>
                  <?= $item->deleted_at instanceof \Cake\I18n\DateTime
                    ? $item->deleted_at->format('d/m/Y H:i')
                    : h($item->deleted_at) ?>
                </span>
              </td>
              <td class="text-end pe-3">
                <?= $this->Form->postLink(
                  '<i class="fas fa-trash-restore me-1"></i> Restaurar',
                  ['action' => 'restore', $tableFilter, $item->id],
                  [
                    'escape'  => false,
                    'class'   => 'btn btn-sm btn-outline-success',
                    'confirm' => 'Restaurar este registro?',
                  ]
                ) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginação -->
      <div class="d-flex justify-content-between align-items-center p-3">
        <p class="text-muted mb-0" style="font-size:.85rem;">
          <?= $this->Paginator->counter('Página {{page}} de {{pages}} — {{count}} registros') ?>
        </p>
        <ul class="pagination pagination-sm mb-0">
          <?= $this->Paginator->prev('<') ?>
          <?= $this->Paginator->numbers() ?>
          <?= $this->Paginator->next('>') ?>
        </ul>
      </div>
    <?php endif; ?>
  </div>
</div>
