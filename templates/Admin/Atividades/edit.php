<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 * @var string[]|\Cake\Collection\CollectionInterface $projetos
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom-info">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-edit me-2"></i><?= __('Editar Relatório Mestre do Curso/Atividade') ?>
                </h6>
                <div class="d-flex align-items-center">
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash me-1"></i> Excluir Curso',
                        ['action' => 'delete', $atividade->id],
                        ['confirm' => __('Atenção! Ao excluir {0}, todas as matrículas e aulas registradas também sumirão. Deseja prosseguir?', $atividade->nome), 'class' => 'btn btn-sm btn-outline-danger shadow-sm me-2', 'escape' => false]
                    ) ?>
                    <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?= $this->Form->create($atividade) ?>
                
                <ul class="nav nav-pills mb-4 pb-2 border-bottom" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold text-info" id="pills-geral-tab" data-toggle="pill" href="#pills-geral" role="tab" aria-selected="true"><i class="fas fa-info-circle me-1"></i> Essenciais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-info" id="pills-logistica-tab" data-toggle="pill" href="#pills-logistica" role="tab" aria-selected="false"><i class="fas fa-map-marked-alt me-1"></i> Logística</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold text-info" id="pills-config-tab" data-toggle="pill" href="#pills-config" role="tab" aria-selected="false"><i class="fas fa-cogs me-1"></i> Configurações</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    
                    <!-- Aba: Essenciais -->
                    <div class="tab-pane fade show active" id="pills-geral" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Nome do Curso / Atividade</label>
                                <?= $this->Form->control('nome', ['class' => 'form-control form-control-lg border-left-info', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Projeto Vinculado</label>
                                <?= $this->Form->control('projeto_id', ['options' => $projetos, 'empty' => 'Sem vínculo', 'class' => 'form-control form-control-lg', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Total de Vagas</label>
                                <?= $this->Form->control('vagas', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Idade Mínima</label>
                                <?= $this->Form->control('idade_minima', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Idade Máxima</label>
                                <?= $this->Form->control('idade_maxima', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="small font-weight-bold text-uppercase text-dark">Descrição Completa</label>
                            <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => false, 'type' => 'textarea', 'rows' => 4]) ?>
                        </div>
                    </div>

                    <!-- Aba: Logística -->
                    <div class="tab-pane fade" id="pills-logistica" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Data de Início</label>
                                <?= $this->Form->control('data_inicio', ['type' => 'date', 'class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Data de Fim</label>
                                <?= $this->Form->control('data_fim', ['type' => 'date', 'class' => 'form-control', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row border-top pt-4">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Dias da Semana</label>
                                <?= $this->Form->control('dias_semana', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Horário de Aulas</label>
                                <?= $this->Form->control('horario', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Local de Atuação</label>
                                <?= $this->Form->control('local', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Aba: Configurações -->
                    <div class="tab-pane fade" id="pills-config" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Responsável Técnico (Usuário)</label>
                                <?= $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Slug (Identificador URL)</label>
                                <?= $this->Form->control('slug', [
                                    'class' => 'form-control border-left-warning bg-light',
                                    'label' => false
                                ]) ?>
                                <small class="text-muted">A url curta da página de inscrição. Mude apenas em casos extremos.</small>
                            </div>
                        </div>

                        <div class="row border-top pt-4">
                            <div class="col-md-12 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Link de Inscrição</label>
                                <div class="input-group">
                                    <?= $this->Form->control('link_inscricao', [
                                        'class' => 'form-control bg-light',
                                        'label' => false,
                                        'readonly' => true,
                                        'id' => 'linkInscricaoTarget'
                                    ]) ?>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" onclick="copiarLinkPainel()">
                                            <i class="fas fa-clipboard"></i> Copiar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 px-3 py-3 rounded mt-2">
                            <div class="custom-control custom-switch">
                                <?= $this->Form->checkbox('publicado', ['class' => 'custom-control-input', 'id' => 'publicadoCheck']) ?>
                                <label class="custom-control-label fw-bold cursor-pointer" for="publicadoCheck">
                                    Disponibilizar atividade publicamente (Visível para Inscrição)
                                </label>
                            </div>
                            <small class="text-muted mt-2 ml-4">Se desativado, o curso ficará oculto e indisponível para o público externo.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <?= $this->Form->button('<i class="fas fa-sync-alt me-2"></i> ' . __('Salvar Alterações'), ['class' => 'btn btn-info btn-lg shadow-sm px-5', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
    function copiarLinkPainel() {
        let input = document.getElementById('linkInscricaoTarget');
        if(!input) return;
        let texto = input.value.replace('/admin/', '/');
        
        navigator.clipboard.writeText(texto).then(function () {
            alert("✅ Link editado/público copiado:\n" + texto);
        }, function (err) {
            alert("❌ Erro ao copiar: " + err);
        });
    }
</script>