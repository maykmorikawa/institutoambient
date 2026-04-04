<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 * @var string[]|\Cake\Collection\CollectionInterface $alunos
 * @var string[]|\Cake\Collection\CollectionInterface $atividades
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $responsavels
 */
?>
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-edit me-2"></i><?= __('Alterar Matrícula') ?> #<?= h($inscrico->id) ?>
                </h6>
                <div class="btn-group shadow-sm">
                    <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
                    <?= $this->Form->postLink(
                        '<i class="fas fa-trash me-1"></i> Excluir',
                        ['action' => 'delete', $inscrico->id],
                        ['confirm' => __('Atenção! Isso removerá permanentemente a matrícula #{0}. Deseja prosseguir?', $inscrico->id), 'class' => 'btn btn-sm btn-danger px-3', 'escape' => false]
                    ) ?>
                </div>
            </div>
            
            <div class="card-body p-4">
                <?= $this->Form->create($inscrico) ?>
                
                <h6 class="heading-small text-muted mb-4 border-bottom pb-2">Vínculos Principais (Quem no Quê)</h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="small font-weight-bold text-uppercase text-dark">Aluno Matriculado</label>
                        <?= $this->Form->control('aluno_id', ['options' => $alunos, 'class' => 'form-control select2 border-left-info bg-light', 'label' => false]) ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Curso / Atividade</label>
                        <?= $this->Form->control('atividade_id', ['options' => $atividades, 'class' => 'form-control select2 border-left-info bg-light', 'label' => false]) ?>
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
                        ]) ?>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-dark">Data de Matrícula/Emissão</label>
                        <?= $this->Form->control('data_inscricao', ['class' => 'form-control', 'label' => false, 'type' => 'date']) ?>
                    </div>
                </div>

                <div class="row border-top pt-4">
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-muted">Acesso Digital do Aluno</label>
                        <?= $this->Form->control('user_id', ['options' => $users, 'empty' => 'Nenhum conta atrelada', 'class' => 'form-control', 'label' => false]) ?>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Conta do fórum que o aluno utilizará.</small>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="small font-weight-bold text-uppercase text-muted">Responsável (Staff)</label>
                        <?= $this->Form->control('responsavel_id', ['options' => $responsavels, 'empty' => 'Nenhum responsável definido', 'class' => 'form-control', 'label' => false]) ?>
                        <small class="text-muted"><i class="fas fa-user-shield"></i> Padrinho / Funcionário que garantiu a matrícula.</small>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex justify-content-end">
                    <?= $this->Form->button('<i class="fas fa-sync-alt me-2"></i> ' . __('Salvar Modificações'), ['class' => 'btn btn-info btn-lg shadow-sm px-5', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>