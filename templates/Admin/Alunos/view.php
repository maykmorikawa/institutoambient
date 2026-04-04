<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */

$idadeStr = '';
if ($aluno->data_nascimento) {
    try {
        $idadeStr = date_diff(date_create($aluno->data_nascimento->format('Y-m-d')), date_create('today'))->y . ' anos';
    } catch (\Exception $e) {}
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-id-card me-2 text-primary"></i><?= __('Dossiê do Cidadão') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-list fa-sm text-white-50 me-1"></i> Diretório', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false, 'title' => 'Voltar à Lista']) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Retificar', ['action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false, 'title' => 'Editar Aluno']) ?>
    </div>
</div>

<div class="row">
    <!-- Coluna Esquerda: ID Card Pessoal -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow border-bottom-primary h-100">
            <div class="card-body p-0">
                <div class="bg-gradient-primary rounded-top border-bottom pt-4 pb-5 px-3 text-center" style="margin-bottom: -40px;">
                    <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center shadow-lg border border-light" style="width: 80px; height: 80px; font-size: 2.2rem; border-width: 4px !important;">
                        <?= mb_substr(h($aluno->nome_completo), 0, 1) ?>
                    </div>
                </div>
                
                <div class="px-4 py-3 pb-5 mt-4 text-center">
                    <h5 class="font-weight-bold text-dark mb-1"><?= h($aluno->nome_completo) ?></h5>
                    <div class="text-muted small mb-3"><i class="fas fa-user-tag me-1"></i> 
                        <?php if($idadeStr): ?>
                            <?= $idadeStr ?> (<?= $aluno->data_nascimento->format('d/m/Y') ?>)
                        <?php else: ?>
                            Nascimento desconhecido
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex justify-content-center mb-4">
                        <?php if ($aluno->hasValue('user')): ?>
                            <span class="badge badge-success px-3 py-2 shadow-sm"><i class="fas fa-globe-americas me-1"></i>Conta Ativa: <?= h($aluno->user->name) ?></span>
                        <?php else: ?>
                            <span class="badge badge-secondary px-3 py-2 shadow-sm"><i class="fas fa-eye-slash me-1"></i>Sem Portal Digital</span>
                        <?php endif; ?>
                    </div>

                    <table class="table table-sm table-borderless text-left small border-top pt-3 mb-0">
                        <tbody>
                            <tr><td class="text-muted w-25"><i class="fas fa-envelope fa-fw me-1"></i></td><td class="font-weight-bold text-dark"><?= h($aluno->email) ?: '-' ?></td></tr>
                            <tr><td class="text-muted"><i class="fas fa-phone fa-fw me-1"></i></td><td class="text-success font-weight-bold"><?= h($aluno->telefone) ?: '-' ?></td></tr>
                            <tr><td class="text-muted"><i class="fas fa-id-card fa-fw me-1 text-gray-500"></i></td><td class="text-dark font-weight-bold">CPF: <?= h($aluno->cpf) ?: '-' ?></td></tr>
                            <tr><td class="text-muted"><i class="fas fa-address-card fa-fw me-1 text-gray-500"></i></td><td class="text-dark">RG: <?= h($aluno->rg) ?: '-' ?></td></tr>
                            <tr><td class="text-muted"><i class="fas fa-hands-helping fa-fw me-1 text-gray-500"></i></td><td class="text-dark">NIS: <?= h($aluno->nis) ?: '-' ?></td></tr>
                            <tr><td class="text-muted"><i class="fas fa-hashtag fa-fw me-1 text-gray-500"></i></td><td class="text-dark">Matrícula Ficha: #<?= $this->Number->format($aluno->id) ?></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light text-center small text-muted border-0 py-2">
                Arquivado as: <?= $aluno->created ? $aluno->created->format('d/m/Y H:i') : '-' ?>
            </div>
        </div>
    </div>

    <!-- Coluna Direita: Paineis Relacionados (Abas) -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header bg-white p-0 border-bottom">
                <ul class="nav nav-tabs border-0" id="aluno-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold px-4 py-3" style="color: #4e73df; border-top: 3px solid #4e73df;" id="tab-inscricoes-tab" data-toggle="tab" href="#tab-inscricoes" role="tab" aria-controls="tab-inscricoes" aria-selected="true"><i class="fas fa-ticket-alt me-1"></i> Inscrições Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold px-4 py-3 text-secondary" id="tab-presencas-tab" data-toggle="tab" href="#tab-presencas" role="tab" aria-controls="tab-presencas" aria-selected="false"><i class="fas fa-user-check me-1"></i> Presenças (Faltas)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold px-4 py-3 text-secondary" id="tab-endereco-tab" data-toggle="tab" href="#tab-endereco" role="tab" aria-controls="tab-endereco" aria-selected="false"><i class="fas fa-map-marked-alt me-1"></i> Endereço</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold px-4 py-3 text-secondary" id="tab-escola-tab" data-toggle="tab" href="#tab-escola" role="tab" aria-controls="tab-escola" aria-selected="false"><i class="fas fa-graduation-cap me-1"></i> Escolaridade</a>
                    </li>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content" id="aluno-tabs-content">
                    
                    <!-- TAB: Inscrições -->
                    <div class="tab-pane fade show active p-4" id="tab-inscricoes" role="tabpanel" aria-labelledby="tab-inscricoes-tab">
                        <?php if (!empty($aluno->inscricoes)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light small text-uppercase">
                                    <tr>
                                        <th>Cód.</th>
                                        <th>Atividade (Curso)</th>
                                        <th>Autorização</th>
                                        <th>Registrado</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($aluno->inscricoes as $inscricao) : 
                                        $cor = strtolower($inscricao->status) == 'confirmada' ? 'success' : (strtolower($inscricao->status) == 'cancelada' ? 'danger' : 'warning');
                                    ?>
                                    <tr>
                                        <td class="text-muted small">#<?= h($inscricao->id) ?></td>
                                        <td class="font-weight-bold text-dark"><?= h($inscricao->atividade_id) ?> 
                                            <!-- Ideal seria ligar o nome da Atividade aqui na association no controller, exibindo apenas o ID por enquanto -->
                                            <a href="/admin/inscricoes/view/<?= $inscricao->id ?>" class="ml-2 small text-primary"><i class="fas fa-external-link-alt"></i></a>
                                        </td>
                                        <td class="small text-muted"><i class="fas fa-user-shield me-1"></i><?= h($inscricao->responsavel_id) ?: 'Desconhecido' ?></td>
                                        <td class="small"><?= $inscricao->data_inscricao ? $inscricao->data_inscricao->format('d/m/Y') : '-' ?></td>
                                        <td><span class="badge badge-<?= $cor ?>"><?= h($inscricao->status) ?></span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-ticket-alt fa-3x mb-3 text-gray-300"></i><br>
                                Nenhuma Inscrição de Curso / Atividade gravada.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- TAB: Presenças -->
                    <div class="tab-pane fade p-4" id="tab-presencas" role="tabpanel" aria-labelledby="tab-presencas-tab">
                        <?php if (!empty($aluno->presencas)) : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light small text-uppercase">
                                    <tr>
                                        <th>Cód. Aula</th>
                                        <th>Situação</th>
                                        <th>Anotação Pessoal</th>
                                        <th>Lanço Sistema</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($aluno->presencas as $presenca) : ?>
                                    <tr>
                                        <td class="font-weight-bold">#<?= h($presenca->aula_id) ?></td>
                                        <td>
                                            <?php if($presenca->presente): ?>
                                                <span class="badge bg-success text-white shadow-sm px-2"><i class="fas fa-check"></i> Presente</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger text-white shadow-sm px-2"><i class="fas fa-times"></i> Faltou</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="small text-muted font-italic"><?= h($presenca->observacoes) ?: '-' ?></td>
                                        <td class="small text-muted"><?= $presenca->created ? $presenca->created->format('d/m/y H:i') : '-' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-calendar-times fa-3x mb-3 text-gray-300"></i><br>
                                Nenhum registro de Presença em aula preenchido.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- TAB: Endereço -->
                    <div class="tab-pane fade p-4" id="tab-endereco" role="tabpanel" aria-labelledby="tab-endereco-tab">
                        <?php if (!empty($aluno->enderecos)) : ?>
                            <?php foreach ($aluno->enderecos as $endereco) : ?>
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-2 text-center text-primary border-right d-none d-md-block">
                                    <i class="fas fa-map-marked-alt fa-2x"></i>
                                </div>
                                <div class="col-md-10">
                                    <h6 class="font-weight-bold text-dark mb-1 d-inline-block"><?= h($endereco->logradouro) ?>, <?= h($endereco->numero) ?></h6>
                                    <?php if($endereco->complemento): ?>
                                        <span class="badge badge-light border ml-2 text-muted"><?= h($endereco->complemento) ?></span>
                                    <?php endif; ?>
                                    
                                    <div class="mt-2 text-muted small">
                                        <i class="fas fa-city me-1"></i> <?= h($endereco->bairro) ?> - <?= h($endereco->cidade) ?>/<?= h($endereco->estado) ?>
                                    </div>
                                    <div class="mt-1 text-primary small font-weight-bold">
                                        <i class="fas fa-mail-bulk me-1"></i> CEP: <?= h($endereco->cep) ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-map-marker-alt fa-3x mb-3 text-gray-300"></i><br>
                                Endereço residencial carente de informações.
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- TAB: Escolaridade -->
                    <div class="tab-pane fade p-4" id="tab-escola" role="tabpanel" aria-labelledby="tab-escola-tab">
                        <?php if (!empty($aluno->escolaridades)) : ?>
                            <?php foreach ($aluno->escolaridades as $escola) : ?>
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-2 text-center text-info border-right d-none d-md-block">
                                    <i class="fas fa-graduation-cap fa-2x"></i>
                                </div>
                                <div class="col-md-10">
                                    <h6 class="font-weight-bold text-dark mb-1">Associação Pedagógica: <span class="text-info"><?= h($escola->instituicao) ?: 'Não declarada' ?></span></h6>
                                    
                                    <div class="mt-2">
                                        <span class="badge bg-light text-dark border p-2 mr-2"><i class="fas fa-layer-group me-1 text-gray-500"></i> Nível: <?= h($escola->nivel) ?></span>
                                        <span class="badge bg-light text-dark border p-2 mr-2"><i class="fas fa-th-list me-1 text-gray-500"></i> Curso/Série: <?= h($escola->curso) ?> <?= h($escola->serie) ?></span>
                                        <span class="badge badge-warning p-2"><i class="fas fa-retweet me-1"></i> <?= h($escola->situacao) ?></span>
                                    </div>
                                    <div class="mt-3 text-muted small">
                                        <i class="fas fa-calendar-check me-1"></i> Formatado/Concluído (Prev.): <strong><?= h($escola->ano_conclusao) ?: 'TBA' ?></strong>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-school fa-3x mb-3 text-gray-300"></i><br>
                                Histórico escolar sem lançamento local.
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Correção dos cliques das tabs do Bootstrap 4 para a View
    $('.nav-tabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        
        // Remover cor ativa dos outros, botar no atual para efeito estetico
        $('.nav-tabs a').removeClass('active').css({'color': '#858796', 'border-top': '1px solid transparent'});
        $(this).addClass('active').css({'color': '#4e73df', 'border-top': '3px solid #4e73df'});
    });
</script>