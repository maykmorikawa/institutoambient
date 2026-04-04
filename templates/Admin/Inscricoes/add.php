<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 * @var \Cake\Collection\CollectionInterface|string[] $alunos
 * @var \Cake\Collection\CollectionInterface|string[] $atividades
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $responsavels
 */
?>
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-ticket-alt me-2"></i><?= __('Registrar Nova Matrícula') ?>
                </h6>
                <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            </div>
            
            <div class="card-body p-4">
                <?= $this->Form->create($inscrico) ?>
                
                <h6 class="heading-small text-muted mb-4 border-bottom pb-2">Vínculos Principais (Quem no Quê)</h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="small font-weight-bold text-uppercase text-dark">Localizar Aluno (Pesquisa Rápida)</label>
                        <?= $this->Form->control('aluno_id', ['options' => $alunos, 'empty' => 'Selecione o aluno pré-cadastrado', 'class' => 'form-control select2', 'label' => false]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Curso / Atividade Desejada</label>
                        <?= $this->Form->control('atividade_id', ['options' => $atividades, 'empty' => 'Selecione o curso com vagas', 'class' => 'form-control select2 border-left-success', 'label' => false]) ?>
                    </div>
                </div>

                <h6 class="heading-small text-muted mb-4 mt-2 border-bottom pb-2">Status e Processamento Administrativo</h6>
                
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Situação da Matrícula</label>
                        <?= $this->Form->control('status', [
                            'class' => 'form-control custom-select border-left-warning',
                            'label' => false,
                            'options' => [                                
                                'pendente' => __('Pendente (Em Análise)'),
                                'confirmada' => __('Confirmada (Ativo)'),
                                'cancelada' => __('Cancelada / Recusada'),
                            ],
                            'default' => 'pendente'
                        ]) ?>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Data de Matrícula/Emissão</label>
                        <?= $this->Form->control('data_inscricao', ['class' => 'form-control', 'label' => false, 'type' => 'date', 'default' => date('Y-m-d')]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-muted">Usuário de Sistema (Opcional)</label>
                        <?= $this->Form->control('user_id', ['options' => $users, 'empty' => 'Nenhum conta atrelada', 'class' => 'form-control', 'label' => false]) ?>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Conta que o aluno utilizará (se houver).</small>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                         <!-- Campo Responsável (Aparentemente presente nas Inscrições embora talvez opcional). 
                              Se for quem cadastrou, não precisa alterar, mas mantemos conforme default  -->
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <?= $this->Form->button('<i class="fas fa-check-circle me-2"></i> ' . __('Efetivar Matrícula'), ['class' => 'btn btn-success btn-lg shadow-sm px-5', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>