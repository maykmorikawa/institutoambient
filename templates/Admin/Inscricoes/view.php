<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 */

$statusCores = [
    'pendente'   => 'warning',
    'confirmada' => 'success',
    'cancelada'  => 'danger',
];
$statusLower = strtolower($inscrico->status);
$corStatus = $statusCores[$statusLower] ?? 'secondary';
$statusIcon = 'circle';
if($statusLower === 'confirmada') $statusIcon = 'check-circle';
if($statusLower === 'cancelada') $statusIcon = 'times-circle';
if($statusLower === 'pendente') $statusIcon = 'clock';
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-ticket-alt me-2 text-<?= $corStatus ?>"></i><?= __('Relatório de Matrícula') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-print fa-sm text-white-50 me-1"></i> Imprimir/Listar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Html->link('<i class="fas fa-edit fa-sm text-white-50 me-1"></i> Configurar Vínculo', ['action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
    </div>
</div>

<div class="row">

    <!-- Ticket da Inscrição (Informações Principais) -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow border-left-<?= $corStatus ?> h-100">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom-<?= $corStatus ?>">
                <h6 class="m-0 font-weight-bold text-<?= $corStatus ?>"><i class="fas fa-bookmark me-2"></i>Credencial Oficial</h6>
                <div class="badge badge-<?= $corStatus ?> p-2 px-3 text-uppercase shadow-sm">
                    <i class="fas fa-<?= $statusIcon ?> me-1"></i> <?= h($inscrico->status) ?>
                </div>
            </div>
            <div class="card-body">
                
                <h6 class="text-uppercase text-muted font-weight-bold mb-3 mt-2 border-bottom pb-2">Conexão Curso » Aluno</h6>
                
                <div class="mb-4 text-center p-3 bg-light rounded border border-gray-200">
                    <div class="text-xs font-weight-bold text-uppercase text-primary mb-1">Curso / Atividade Matriculada</div>
                    <?php if ($inscrico->hasValue('atividade')): ?>
                        <h5 class="font-weight-bold text-dark mb-0"><?= h($inscrico->atividade->nome) ?></h5>
                        <?= $this->Html->link('<i class="fas fa-layer-group me-1"></i> Ver painel do curso', ['controller' => 'Atividades', 'action' => 'view', $inscrico->atividade->id], ['class' => 'small mt-2 d-inline-block text-primary', 'escape' => false]) ?>
                    <?php else: ?>
                        <span class="text-danger mt-3 d-inline-block"><i class="fas fa-unlink"></i> Conexão perdida (Atividade Removida)</span>
                    <?php endif; ?>
                </div>

                <ul class="list-group list-group-flush small border-top pt-3">
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-calendar-check me-2"></i> Data de Fechamento</span>
                        <span class="font-weight-bold text-dark"><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '<i class="text-muted">Não estabelecida</i>' ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-passport me-2"></i> Número da Ficha / Controle</span>
                        <span class="text-dark">ID #<?= $this->Number->format($inscrico->id) ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span class="text-muted"><i class="fas fa-globe me-2"></i> Conta Digital Conectada</span>
                        <span class="text-dark"><?= $inscrico->hasValue('user') ? $this->Html->link($inscrico->user->name, ['controller' => 'Users', 'action' => 'view', $inscrico->user->id], ['class' => 'font-weight-bold text-info']) : '<span class="text-muted">Nenhuma</span>' ?></span>
                    </li>
                    <li class="list-group-item px-0 d-flex justify-content-between border-bottom border-gray-200">
                        <span class="text-muted"><i class="fas fa-user-shield me-2"></i> Responsável Validou</span>
                        <span class="text-dark"><?= $inscrico->hasValue('responsavel') ? h($inscrico->responsavel->name) : '<span class="text-muted">Desconhecido</span>' ?></span>
                    </li>
                    <li class="list-group-item px-0 pt-3 border-0 bg-transparent text-center text-xs text-muted">
                        Última movimentação feita no sistema: <?= $inscrico->modified ? $inscrico->modified->format('d/m/Y H:i') : '-' ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Perfil Completo do Aluno (Resumo) -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3 bg-white">
                <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-user-graduate me-2 text-gray-400"></i>Perfil do Aluno Fichado</h6>
            </div>
            
            <?php if ($inscrico->hasValue('aluno')): ?>
            <div class="card-body">
                <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 50px; height: 50px; font-size: 1.5rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="ml-3">
                        <h5 class="font-weight-bold text-dark mb-0"><?= h($inscrico->aluno->nome_completo) ?></h5>
                        <div class="text-muted small">Cidadão / Estudante</div>
                    </div>
                </div>

                <h6 class="small font-weight-bold text-uppercase text-muted mb-2">Dados de Contato e Documentação</h6>
                
                <table class="table table-borderless table-sm small">
                    <tbody>
                        <tr>
                            <td class="text-muted pr-3" style="width: 140px;"><i class="fas fa-envelope fa-fw me-1"></i> E-mail Cadastrado:</td>
                            <td class="font-weight-bold text-dark"><?= h($inscrico->aluno->email) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-id-card fa-fw me-1"></i> CPF Oficial:</td>
                            <td class="text-dark"><?= h($inscrico->aluno->cpf) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-phone-alt fa-fw me-1"></i> Telefone Direto:</td>
                            <td class="text-dark bg-light px-2 rounded w-auto d-inline-block"><?= h($inscrico->aluno->telefone) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted"><i class="fas fa-birthday-cake fa-fw me-1"></i> Nascimento:</td>
                            <td class="text-dark"><?= $inscrico->aluno->data_nascimento ? $inscrico->aluno->data_nascimento->format('d/m/Y') : '<i class="text-muted">Não conta</i>' ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="mt-4 pt-3 border-top text-center border-gray-200">
                    <?= $this->Html->link('<i class="fas fa-users-cog me-2"></i>Dossiê Completo do Aluno', ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id], ['class' => 'btn btn-light border shadow-sm w-100 font-weight-bold text-primary', 'escape' => false]) ?>
                </div>
            </div>
            <?php else: ?>
            <div class="card-body text-center d-flex flex-column justify-content-center py-5 text-muted">
                <i class="fas fa-user-slash fa-4x mb-3 text-gray-300"></i>
                <h5 class="font-weight-bold text-dark">Matrícula Órfã</h5>
                <p>Nenhum aluno está vinculado a este registro. Foi removido do servidor.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .ml-3 { margin-left: 1rem; }
    .mr-1 { margin-right: 0.25rem; }
</style>
