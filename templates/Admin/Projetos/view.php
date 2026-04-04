<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 */

$statusCores = [
    'planejamento' => 'info',
    'andamento'    => 'warning',
    'concluido'    => 'success',
    'cancelado'    => 'danger',
];
$corAtiva = $statusCores[$projeto->status] ?? 'secondary';
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-project-diagram me-2 text-<?= $corAtiva ?>"></i><?= __('Relatório do Projeto') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-print fa-sm text-white-50 me-1"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Editar Projeto', ['action' => 'edit', $projeto->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
    </div>
</div>

<div class="row">
    <!-- Coluna Esquerda: Ficha Técnica -->
    <div class="col-lg-4 mb-4">
        <!-- Ficha Técnica Básica -->
        <div class="card shadow border-bottom-<?= $corAtiva ?> h-100">
            <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-<?= $corAtiva ?>"><?= __('Informações Gerais') ?></h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Ações:</div>
                        <?= $this->Html->link('<i class="fas fa-edit me-2"></i>Editar', ['action' => 'edit', $projeto->id], ['class' => 'dropdown-item text-primary', 'escape' => false]) ?>
                        <div class="dropdown-divider"></div>
                        <?= $this->Form->postLink('<i class="fas fa-trash-alt me-2"></i>Excluir Projeto', ['action' => 'delete', $projeto->id], ['confirm' => __('PERIGO: Deseja excluir #{0} e tudo contido nele?', $projeto->id), 'class' => 'dropdown-item text-danger', 'escape' => false]) ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-4 mt-2">
                    <h5 class="font-weight-bold text-dark mb-1"><?= h($projeto->name) ?></h5>
                    <div class="small text-muted mb-2 text-uppercase font-weight-bold tracking-wide">Status Principal</div>
                    
                    <span class="badge border border-<?= $corAtiva ?> text-<?= $corAtiva ?> p-2 px-3 text-uppercase mr-1" style="font-size: 0.85rem;"><i class="fas fa-dot-circle me-1"></i> <?= h($projeto->status) ?></span>
                    
                    <?php if ($projeto->publicado): ?>
                        <span class="badge badge-success p-2 px-3 text-uppercase" style="font-size: 0.85rem;"><i class="fas fa-globe-americas me-1"></i> Público</span>
                    <?php endif; ?>
                </div>

                <ul class="list-group list-group-flush small border-top pt-3">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-user-tie me-2"></i> Coordenação</span>
                        <span class="font-weight-bold text-dark">
                            <?= $projeto->hasValue('user') ? $this->Html->link($projeto->user->name, ['controller' => 'Users', 'action' => 'view', $projeto->user->id], ['class' => 'text-primary']) : '<i class="text-muted">Sem Coordenador</i>' ?>
                        </span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-calendar-check me-2"></i> Data de Início</span>
                        <span class="text-dark"><?= $projeto->data_inicio ? $projeto->data_inicio->format('d/m/Y') : '-' ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between border-bottom">
                        <span class="text-muted"><i class="fas fa-calendar-times me-2"></i> Data de Fim</span>
                        <span class="text-dark"><?= $projeto->data_fim ? $projeto->data_fim->format('d/m/Y') : '<i class="text-success text-xs">Em Aberto</i>' ?></span>
                    </li>
                    <li class="list-group-item px-0 pt-3 border-0 bg-transparent">
                        <div class="text-xs text-muted mb-1">Registro / Sistema:</div>
                        <div class="d-flex justify-content-between text-xs">
                            <span>ID #<?= $this->Number->format($projeto->id) ?></span>
                            <span>Criado em: <?= $projeto->created ? $projeto->created->format('d/m/Y') : '-' ?></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Descrição e Sub-ítens -->
    <div class="col-lg-8 mb-4">
        
        <!-- Bloco Descrição -->
        <?php if (!empty($projeto->descricao)): ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white border-bottom-0 pb-0">
                <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-align-left me-2 text-gray-400"></i>Sinopse / Descrição Oficial</h6>
            </div>
            <div class="card-body pt-2 text-gray-800 text-justify line-height-lg md-content">
                <?= $this->Text->autoParagraph(h($projeto->descricao)); ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Bloco Atividades Relacionadas -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-white d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-graduation-cap me-2"></i><?= __('Cursos / Atividades dentro do Projeto') ?></h6>
                <div>
                     <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> Adicionar Atividade', ['controller' => 'Atividades', 'action' => 'add', '?' => ['projeto_id' => $projeto->id]], ['class' => 'btn btn-sm btn-primary shadow-sm', 'escape' => false]) ?>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($projeto->atividades)) : ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-dark text-xs text-uppercase">
                                <tr>
                                    <th class="px-3">Curso/Atividade</th>
                                    <th class="text-center">Vagas</th>
                                    <th>Horário</th>
                                    <th class="text-center">Status Público</th>
                                    <th class="text-center">Painel</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($projeto->atividades as $atividade) : ?>
                                    <tr>
                                        <td class="px-3">
                                            <div class="font-weight-bold text-dark mb-0"><?= h($atividade->nome) ?></div>
                                            <small class="text-muted"><i class="fas fa-map-marker-alt"></i> <?= h($atividade->local) ?: 'Local indefinido' ?></small>
                                        </td>
                                        <td class="text-center font-weight-bold text-primary">
                                            <?= $this->Number->format($atividade->vagas) ?>
                                        </td>
                                        <td class="small">
                                            <div class="text-dark"><i class="fas fa-clock text-warning mr-1"></i><?= h($atividade->horario) ?: '-' ?></div>
                                            <div class="text-muted"><?= h($atividade->dias_semana) ?></div>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($atividade->publicado): ?>
                                                <i class="fas fa-check-circle text-success" title="Inscrições Abertas (Público)"></i>
                                            <?php else: ?>
                                                <i class="fas fa-eye-slash text-danger" title="Oculto ao Público"></i>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <?= $this->Html->link('<i class="fas fa-external-link-alt text-primary"></i>', ['controller' => 'Atividades', 'action' => 'view', $atividade->id], ['class' => 'btn btn-sm btn-light border p-1', 'escape' => false, 'title' => 'Painel Completo do Curso']) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-chalkboard fa-3x mb-3 d-block text-gray-300"></i>
                        Vazio. Este projeto ainda não abriga nenhum curso ou atividade.
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($projeto->atividades)) : ?>
            <div class="card-footer bg-white text-muted text-xs text-right border-top-0 pt-0">
                Mostrando <?= count($projeto->atividades) ?> curso(s) vinculado(s)
            </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
    .line-height-lg blockquote, .line-height-lg p { line-height: 1.6; }
    .table td, .table th { padding: 0.85rem 0.5rem; }
    .btn-light { background: #fff; border-color: #eaecf4; }
    .btn-light:hover { background: #f8f9fc; }
    .tracking-wide { letter-spacing: 0.05em; }
</style>