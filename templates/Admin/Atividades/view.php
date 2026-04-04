<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 */
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-graduation-cap me-2 text-primary"></i><?= __('Painel do Curso') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-print fa-sm text-white-50 me-1"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Configurar Curso', ['action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
    </div>
</div>

<div class="row">
    <!-- Coluna Lateral Esquerda: ID e Ficha Técnica Básica -->
    <div class="col-lg-4 mb-4">
        <!-- Detalhes do Curso -->
        <div class="card shadow border-bottom-primary h-100">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-primary"><?= __('Ficha Técnica') ?></h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center mx-auto mb-3 shadow" style="width: 70px; height: 70px; font-size: 2rem;">
                        <i class="fas fa-book-reader"></i>
                    </div>
                    <h5 class="font-weight-bold text-dark mb-1"><?= h($atividade->nome) ?></h5>
                    <?php if ($atividade->hasValue('projeto')): ?>
                        <div class="small text-muted mb-2">Projeto: <?= $this->Html->link(h($atividade->projeto->name), ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id], ['class' => 'text-info']) ?></div>
                    <?php endif; ?>
                    
                    <div class="mt-2 text-center">
                        <?php if ($atividade->publicado): ?>
                            <span class="badge badge-success px-3 py-1 bg-gradient-success"><i class="fas fa-lock-open me-1"></i> Público para Matrículas</span>
                        <?php else: ?>
                            <span class="badge badge-danger px-3 py-1"><i class="fas fa-lock me-1"></i> Inscrições Fechadas</span>
                        <?php endif; ?>
                    </div>
                </div>

                <ul class="list-group list-group-flush small border-top pt-3">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-users me-2"></i>Vagas</span>
                        <span class="font-weight-bold h6 mb-0 text-dark"><?= $this->Number->format($atividade->vagas) ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-child me-2"></i>Faixa Etária</span>
                        <span>Min: <?= $this->Number->format($atividade->idade_minima) ?> <?= $atividade->idade_maxima ? '| Max: '.$this->Number->format($atividade->idade_maxima) : '' ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-map-marker-alt me-2"></i>Local</span>
                        <span class="text-right"><?= h($atividade->local) ?: '-' ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between align-items-start">
                        <span class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Turno / Dias</span>
                        <span class="text-right d-block">
                            <?= h($atividade->horario) ?: '-' ?><br>
                            <small class="text-primary"><?= h($atividade->dias_semana) ?></small>
                        </span>
                    </li>
                    <li class="list-group-item px-0 d-block mt-2 align-items-center">
                        <div class="text-muted mb-2"><i class="fas fa-share-alt me-2"></i>Link Público de Matrícula:</div>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" id="link-inscricao" value="<?= h(str_replace('/admin/', '/', $atividade->link_inscricao)) ?>" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="button" onclick="navigator.clipboard.writeText(document.getElementById('link-inscricao').value); alert('Copiado!')"><i class="fas fa-copy"></i> Copiar</button>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Tabelões de Operação e Listagens -->
    <div class="col-lg-8 mb-4">

        <!-- Descrição -->
        <?php if (!empty($atividade->descricao)): ?>
        <div class="card shadow mb-4">
            <a href="#collapseDescricao" class="d-block card-header py-3 bg-white border-bottom-0" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseDescricao">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-indent me-2"></i>Sobre o Curso</h6>
            </a>
            <div class="collapse show" id="collapseDescricao">
                <div class="card-body pt-0 text-gray-800 small border-top pt-3 text-justify">
                    <?= $this->Text->autoParagraph(h($atividade->descricao)); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Alunos Inscritos -->
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-users me-2"></i><?= __('Matrículas / Alunos') ?></h6>
                <span class="badge badge-success"><?= !empty($atividade->inscricoes) ? count($atividade->inscricoes) : 0 ?> Registros</span>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($atividade->inscricoes)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-sm">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th class="px-3" style="width: 80px;">Matrícula</th>
                                    <th>Aluno</th>
                                    <th class="text-center">Adesão</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($atividade->inscricoes as $inscricao): ?>
                                    <tr>
                                        <td class="px-3 text-muted">#<?= h($inscricao->aluno_id) ?></td>
                                        <td class="font-weight-bold text-dark"><?= h($inscricao->aluno->nome_completo ?? 'Não informado') ?></td>
                                        <td class="text-center small"><?= $inscricao->data_inscricao ? $inscricao->data_inscricao->format('d/m/Y') : '-' ?></td>
                                        <td class="text-center">
                                            <span class="badge badge-secondary"><?= h($inscricao->status) ?></span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <?= $this->Html->link('<i class="fas fa-eye text-primary"></i>', ['controller' => 'Inscricoes', 'action' => 'view', $inscricao->id], ['class' => 'btn btn-sm btn-light border p-1', 'escape' => false, 'title' => 'Ver Ficha']) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 px-3 text-muted">
                        <i class="fas fa-user-times fa-2x mb-2 text-gray-300"></i><br>
                        Nenhum aluno matriculado nessa atividade até o momento.
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Aulas & Frequência (Fundidos em um único gerenciador UI) -->
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-chalkboard-teacher me-2"></i><?= __('Plano de Aulas e Chamada') ?></h6>
                <span class="badge badge-warning text-dark"><?= !empty($atividade->aulas) ? count($atividade->aulas) : 0 ?> Aulas</span>
            </div>
            <div class="card-body p-0">
                <?php if (!empty($atividade->aulas)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-sm">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th class="px-3" style="width: 100px;">Data</th>
                                    <th>Conteúdo Aplicado</th>
                                    <th class="text-center">Administração</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($atividade->aulas as $aula): ?>
                                    <tr>
                                        <td class="px-3 font-weight-bold text-dark">
                                            <i class="fas fa-calendar-day text-muted me-1"></i>
                                            <?= $aula->data ? $aula->data->format('d/m/y') : '-' ?>
                                        </td>
                                        <td>
                                            <?= h($aula->conteudo) ?: '<i class="text-muted">Não informado</i>' ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                <?= $this->Html->link(
                                                    '<i class="fas fa-check-square me-1"></i> Fazer Chamada',
                                                    ['controller' => 'Presencas', 'action' => 'marcar', $aula->id],
                                                    ['class' => 'btn btn-sm btn-success shadow-sm me-2', 'escape' => false]
                                                ) ?>
                                                <div class="btn-group">
                                                    <?= $this->Html->link('<i class="fas fa-pencil-alt text-primary"></i>', ['controller' => 'Aulas', 'action' => 'edit', $aula->id], ['class' => 'btn btn-sm btn-light border p-1', 'escape' => false, 'title' => 'Editar Aula']) ?>
                                                    <?= $this->Form->postLink(
                                                        '<i class="fas fa-trash text-danger"></i>',
                                                        ['controller' => 'Aulas', 'action' => 'delete', $aula->id],
                                                        ['confirm' => __('Atenção! Ao excluir a aula do dia {0}, a chamada já feita se perderá. Prosseguir?', $aula->data?$aula->data->format('d/m/Y'):''), 'class' => 'btn btn-sm btn-light border p-1', 'escape' => false, 'title' => 'Excluir Aula']
                                                    ) ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 px-3 text-muted">
                        <i class="fas fa-chalkboard fa-2x mb-2 text-gray-300"></i><br>
                        Nenhuma aula programada ou registrada.
                    </div>
                <?php endif; ?>
                
                <div class="card-footer bg-white text-center py-3">
                    <!-- Supondo que exista um botão de adicionar aula para essa atividade no controller Aulas -->
                    <?= $this->Html->link('<i class="fas fa-plus-circle me-1"></i> Registrar Nova Aula', ['controller' => 'Aulas', 'action' => 'add', '?' => ['atividade_id' => $atividade->id]], ['class' => 'btn btn-warning btn-sm text-dark font-weight-bold shadow-sm', 'escape' => false]) ?>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .btn-light { background: #fff; }
    .btn-light:hover { background: #f8f9fc; }
    .table td, .table th { padding: 0.85rem 0.5rem; }
    .bg-gradient-success {
        background: linear-gradient(180deg, #1cc88a 10%, #13855c 100%);
    }
</style>