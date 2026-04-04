<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Projeto $projeto
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row justify-content-center">
    <div class="col-xl-9 col-lg-10">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-project-diagram me-2"></i><?= __('Criar Novo Projeto') ?>
                </h6>
                <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            </div>
            
            <div class="card-body p-4">
                <?= $this->Form->create($projeto) ?>
                
                <h6 class="heading-small text-muted mb-4 border-bottom pb-2">Identificação do Projeto</h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="small font-weight-bold text-uppercase text-dark">Nome do Projeto</label>
                        <?= $this->Form->control('name', ['class' => 'form-control form-control-lg border-left-primary', 'label' => false, 'placeholder' => 'Digite o nome do Projeto Educacional']) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Descrição Oficial</label>
                        <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => false, 'type' => 'textarea', 'rows' => 3, 'placeholder' => 'Informe a finalidade e base descritiva do projeto...']) ?>
                    </div>
                </div>

                <h6 class="heading-small text-muted mb-4 mt-2 border-bottom pb-2">Coordenação e Prazos</h6>
                
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Líder / Coordenador</label>
                        <?= $this->Form->control('user_id', ['class' => 'form-control custom-select', 'label' => false, 'empty' => 'Sem usuário assinalado']) ?>
                    </div>
                    
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Andamento (Status)</label>
                        <?= $this->Form->control('status', [
                            'class' => 'form-control custom-select',
                            'label' => false,
                            'options' => [
                                'planejamento' => __('Planejamento'),
                                'andamento' => __('Andamento'),
                                'concluido' => __('Concluído'),
                                'cancelado' => __('Cancelado'),
                            ],
                        ]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Data de Lançamento</label>
                        <?= $this->Form->control('data_inicio', ['class' => 'form-control', 'label' => false, 'type' => 'date']) ?>
                    </div>
                    
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Data de Encerramento</label>
                        <?= $this->Form->control('data_fim', ['class' => 'form-control', 'label' => false, 'type' => 'date']) ?>
                    </div>
                </div>

                <h6 class="heading-small text-muted mb-4 mt-2 border-bottom pb-2">Visibilidade</h6>
                
                <div class="card bg-light border-0 px-3 py-3 rounded mb-4">
                    <div class="custom-control custom-switch">
                        <?= $this->Form->checkbox('publicado', [
                            'class' => 'custom-control-input',
                            'id' => 'publicadoSwitch',
                            'checked' => true
                        ]) ?>
                        <label class="custom-control-label fw-bold cursor-pointer text-dark" for="publicadoSwitch">
                            Tornar Projeto Aberto ao Público
                        </label>
                    </div>
                    <small class="text-muted mt-2 ml-4">Se marcado, o projeto visará atrair matrículas globais. Caso contrário, será tratado como projeto fechado interno.</small>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <?= $this->Form->button('<i class="fas fa-save me-2"></i> ' . __('Construir Projeto'), ['class' => 'btn btn-primary btn-lg shadow-sm px-5', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>