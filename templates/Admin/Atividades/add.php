<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 * @var \Cake\Collection\CollectionInterface|string[] $projetos
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom-primary">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-graduation-cap me-2"></i><?= __('Adicionar Nova Atividade / Curso') ?>
                </h6>
                <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            </div>
            
            <div class="card-body p-4">
                <?= $this->Form->create($atividade) ?>
                
                <ul class="nav nav-pills mb-4 pb-2 border-bottom" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-bold" id="pills-geral-tab" data-toggle="pill" href="#pills-geral" role="tab" aria-selected="true"><i class="fas fa-info-circle me-1"></i> Essenciais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="pills-logistica-tab" data-toggle="pill" href="#pills-logistica" role="tab" aria-selected="false"><i class="fas fa-map-marked-alt me-1"></i> Logística</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" id="pills-config-tab" data-toggle="pill" href="#pills-config" role="tab" aria-selected="false"><i class="fas fa-cogs me-1"></i> Configurações</a>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    
                    <!-- Aba: Essenciais -->
                    <div class="tab-pane fade show active" id="pills-geral" role="tabpanel">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Nome do Curso / Atividade</label>
                                <?= $this->Form->control('nome', ['class' => 'form-control form-control-lg border-left-primary', 'label' => false, 'placeholder' => 'Ex: Curso Especial de Corte e Costura']) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Projeto Vinculado</label>
                                <?= $this->Form->control('projeto_id', ['options' => $projetos, 'empty' => 'Sem vínculo', 'class' => 'form-control form-control-lg', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Total de Vagas</label>
                                <?= $this->Form->control('vagas', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Ex: 40']) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Idade Mínima</label>
                                <?= $this->Form->control('idade_minima', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Ex: 14']) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Idade Máxima</label>
                                <?= $this->Form->control('idade_maxima', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Opcional']) ?>
                            </div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label class="small font-weight-bold text-uppercase text-dark">Descrição Completa</label>
                            <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => false, 'type' => 'textarea', 'rows' => 4, 'placeholder' => 'Detalhe o que será ensinado neste curso...']) ?>
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
                                <?= $this->Form->control('dias_semana', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Ex: Segundas e Quartas']) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Horário de Aulas</label>
                                <?= $this->Form->control('horario', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Ex: 14:00 - 17:00']) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-uppercase text-dark">Local de Atuação</label>
                                <?= $this->Form->control('local', ['class' => 'form-control', 'label' => false, 'placeholder' => 'Ex: Sala 02 do Prédio B']) ?>
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
                                    'class' => 'form-control border-left-warning',
                                    'label' => false,
                                    'disabled' => true,
                                    'placeholder' => 'Gerado automaticamente ao salvar'
                                ]) ?>
                                <small class="text-muted">A url curta da página de inscrição.</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label class="small font-weight-bold text-uppercase text-dark">Link de Inscrição</label>
                                <?= $this->Form->control('link_inscricao', [
                                    'class' => 'form-control bg-light',
                                    'label' => false,
                                    'disabled' => true,
                                    'placeholder' => 'Estará disponível para copiar após o cadastro ser concluído'
                                ]) ?>
                            </div>
                        </div>

                        <div class="card bg-light border-0 px-3 py-3 rounded">
                            <div class="custom-control custom-switch">
                                <?= $this->Form->checkbox('publicado', ['class' => 'custom-control-input', 'id' => 'publicadoCheck', 'checked' => true]) ?>
                                <label class="custom-control-label fw-bold cursor-pointer" for="publicadoCheck">
                                    Disponibilizar atividade publicamente (Visível para Inscrição)
                                </label>
                            </div>
                            <small class="text-muted mt-2 ml-4">Se desativado, o curso ficará como "Oculto" e apenas administradores poderão ver e forçar inscrições.</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <?= $this->Form->button('<i class="fas fa-save me-2"></i> ' . __('Salvar Atividade'), ['class' => 'btn btn-primary btn-lg shadow-sm px-5', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>