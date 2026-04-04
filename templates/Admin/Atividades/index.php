<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Atividade> $atividades
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
            <i class="fas fa-graduation-cap me-2"></i><?= __('Catálogo de Atividades (Cursos)') ?>
        </h6>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> Nova Atividade', ['action' => 'add'], ['class' => 'btn btn-primary shadow-sm btn-sm', 'escape' => false]) ?>
    </div>
    
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="dataTable" width="100%" cellspacing="0">
                <thead class="bg-light text-dark small text-uppercase">
                    <tr>
                        <th style="width: 60px;"><?= $this->Paginator->sort('id', 'ID') ?></th>
                        <th style="width: 25%;"><?= $this->Paginator->sort('nome', 'Curso / Atividade') ?></th>
                        <th><?= $this->Paginator->sort('projeto_id', 'Projeto Vinculado') ?></th>
                        <th><?= $this->Paginator->sort('vagas', 'Vagas') ?></th>
                        <th><?= $this->Paginator->sort('horario', 'Logística') ?></th>
                        <th class="text-center"><?= $this->Paginator->sort('publicado', 'Status') ?></th>
                        <th class="text-center" style="width: 150px;"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($atividades->items()->isEmpty()): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-graduation-cap fa-3x mb-3 d-block text-gray-300"></i>
                                Nenhuma atividade ou curso encontrado.
                            </td>
                        </tr>
                    <?php endif; ?>

                    <?php foreach ($atividades as $atividade): ?>
                        <tr>
                            <td class="text-muted font-weight-bold small">#<?= $this->Number->format($atividade->id) ?></td>
                            <td>
                                <div class="font-weight-bold text-primary mb-1"><?= h($atividade->nome) ?></div>
                                <div class="d-flex align-items-center mb-1">
                                    <button class="btn btn-sm btn-outline-secondary py-0 px-2 small me-2" onclick="copiarLink('<?= h($atividade->link_inscricao) ?>')" title="Copiar Link de Matrícula">
                                        <i class="fas fa-link fa-xs"></i>
                                    </button>
                                    <span class="text-muted small text-truncate" style="max-width: 150px;"><?= h($atividade->slug) ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if ($atividade->hasValue('projeto')): ?>
                                    <?= $this->Html->link('<i class="fas fa-project-diagram me-1"></i> ' . h($atividade->projeto->name), ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id], ['class' => 'badge badge-info shadow-sm p-2 text-decoration-none', 'escape' => false]) ?>
                                <?php else: ?>
                                    <span class="badge badge-secondary shadow-sm p-2"><i class="fas fa-ban me-1"></i> Sem Projeto</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="font-weight-bold h5 mb-0 text-gray-800"><?= $this->Number->format($atividade->vagas) ?></div>
                                <small class="text-muted text-uppercase" style="font-size: 0.6rem;">Disponíveis</small>
                            </td>
                            <td class="small">
                                <div><i class="fas fa-map-marker-alt text-danger me-1"></i> <?= h($atividade->local) ?: '<span class="text-muted">Não definido</span>' ?></div>
                                <div class="mt-1"><i class="fas fa-clock text-warning me-1"></i> <?= h($atividade->horario) ?: '<span class="text-muted">Não definido</span>' ?></div>
                                <div class="mt-1"><i class="fas fa-calendar-week text-primary me-1"></i> <?= h($atividade->dias_semana) ?: '<span class="text-muted">Não definido</span>' ?></div>
                            </td>
                            <td class="text-center">
                                <?php if ($atividade->publicado): ?>
                                    <span class="badge badge-success shadow-sm px-2"><i class="fas fa-globe-americas me-1"></i>Público</span>
                                <?php else: ?>
                                    <span class="badge badge-danger shadow-sm px-2"><i class="fas fa-eye-slash me-1"></i>Oculto</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm">
                                    <?= $this->Html->link('<i class="fas fa-eye text-secondary"></i>', ['action' => 'view', $atividade->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Visualizar', 'escape' => false]) ?>
                                    <?= $this->Html->link('<i class="fas fa-edit text-primary"></i>', ['action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-white', 'title' => 'Editar', 'escape' => false]) ?>
                                    <?= $this->Form->postLink('<i class="fas fa-trash text-danger"></i>', ['action' => 'delete', $atividade->id], ['confirm' => __('Você tem certeza que deseja excluir a atividade {0} e todas as suas inscrições?', $atividade->nome), 'class' => 'btn btn-sm btn-white', 'title' => 'Excluir', 'escape' => false]) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="mb-3 mb-md-0 small text-muted">
                <?= $this->Paginator->counter('Página {{page}} de {{pages}} &middot; Mostrando {{current}} de {{count}} registros') ?>
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

<!-- Script para copiar -->
<script>
    function copiarLink(link) {
        if(!link) return;
        // Remove "/admin" se estiver no link
        let texto = link.replace('/admin/', '/');

        // Se o link vier só a slug e não for URL absoluta, podemos tentar compor com window.location.origin
        // Mas a lógica original copiava o texto exibido na var. Assumiremos a mesma lógica.
        
        navigator.clipboard.writeText(texto).then(function () {
            alert("✅ Link de inscrição copiado com sucesso:\n" + texto);
        }, function (err) {
            alert("❌ Erro ao copiar link: " + err);
        });
    }
</script>