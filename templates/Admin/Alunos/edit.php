<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */

$loggedInUserId = null;
if ($this->request->getAttribute('identity')) {
    $loggedInUserId = $this->request->getAttribute('identity')->getIdentifier();
}
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-edit me-2 text-primary"></i><?= __('Atualizar Cadastro Cidadão') ?>
    </h1>
    <div class="btn-group shadow-sm">
        <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
        <?= $this->Form->postLink(
            '<i class="fas fa-trash fa-sm text-white-50 me-1"></i> Excluir Base',
            ['action' => 'delete', $aluno->id],
            ['confirm' => __('PERIGO: Se você excluir {0}, todas as matrículas atreladas vão desaparecer. Quer prosseguir?', $aluno->nome_completo), 'class' => 'btn btn-sm btn-danger px-3', 'escape' => false]
        ) ?>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-lg-4 mb-4">
        <!-- Navegação (Pills Lateral) -->
        <div class="card shadow border-left-primary h-100">
            <div class="card-body p-0">
                <div class="nav flex-column nav-pills" id="aluno-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active rounded-0 p-3 border-bottom" id="pills-dados-tab" data-toggle="pill" href="#pills-dados" role="tab" aria-controls="pills-dados" aria-selected="true">
                        <i class="fas fa-address-card fa-fw me-2 text-gray-400"></i> <span class="font-weight-bold">Dados Físicos</span>
                        <div class="small text-muted mt-1 " style="margin-left:28px;">Nome, CPF, Contato...</div>
                    </a>
                    <a class="nav-link rounded-0 p-3 border-bottom" id="pills-endereco-tab" data-toggle="pill" href="#pills-endereco" role="tab" aria-controls="pills-endereco" aria-selected="false">
                        <i class="fas fa-map-marker-alt fa-fw me-2 text-gray-400"></i> <span class="font-weight-bold">Localização</span>
                        <div class="small text-muted mt-1 " style="margin-left:28px;">Atualizar endereço do arquivo.</div>
                    </a>
                    <a class="nav-link rounded-0 p-3" id="pills-escolaridade-tab" data-toggle="pill" href="#pills-escolaridade" role="tab" aria-controls="pills-escolaridade" aria-selected="false">
                        <i class="fas fa-graduation-cap fa-fw me-2 text-gray-400"></i> <span class="font-weight-bold">Saber Acadêmico</span>
                        <div class="small text-muted mt-1 " style="margin-left:28px;">Modificar níveis de instrução.</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteúdo do Formulário -->
    <div class="col-xl-9 col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-body p-5">
                <?= $this->Form->create($aluno, ['novalidate' => true]) ?>
                
                <div class="tab-content" id="aluno-pills-tabContent">
                    
                    <!-- Aba: Dados => ID = pills-dados -->
                    <div class="tab-pane fade show active" id="pills-dados" role="tabpanel" aria-labelledby="pills-dados-tab">
                        <h5 class="text-dark font-weight-bold border-bottom pb-3 mb-4">Qualificação Civil (Identificação)</h5>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="small font-weight-bold text-dark">Nome Completo</label>
                                <?= $this->Form->control('nome_completo', ['class' => 'form-control border-left-primary', 'label' => false, 'placeholder' => 'Nome da pessoa sem abreviações']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">E-mail</label>
                                <?= $this->Form->control('email', ['type' => 'email', 'class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">Telefone / WhatsApp</label>
                                <?= $this->Form->control('telefone', ['class' => 'form-control mascara-telefone border-left-success', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">CPF Oficial</label>
                                <?= $this->Form->control('cpf', ['class' => 'form-control mascara-cpf', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">RG Identidade</label>
                                <?= $this->Form->control('rg', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">Data de Nascimento</label>
                                <?= $this->Form->control('data_nascimento', ['type' => 'date', 'class' => 'form-control border-left-info', 'label' => false]) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">NIS (Social)</label>
                                <?= $this->Form->control('nis', ['class' => 'form-control bg-light', 'label' => false]) ?>
                            </div>
                        </div>

                        <h5 class="text-dark font-weight-bold border-bottom mt-5 pb-3 mb-4">Acesso Vinculado</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark text-uppercase">Conta Eletrônica</label>
                                <?= $this->Form->control('user_id', ['options' => $users, 'empty' => 'Nenhum conta atrelada ao aluno', 'class' => 'form-control custom-select', 'label' => false]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Aba: Endereço => ID = pills-endereco -->
                    <div class="tab-pane fade" id="pills-endereco" role="tabpanel" aria-labelledby="pills-endereco-tab">
                        <h5 class="text-dark font-weight-bold border-bottom pb-3 mb-4">Mapeamento Residencial</h5>
                        <?= $this->Form->hidden('enderecos.0.id') ?>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">CEP</label>
                                <?= $this->Form->control('enderecos.0.cep', ['class' => 'form-control mascara-cep border-left-primary', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label class="small font-weight-bold text-dark">Rua / Avenida / Logradouro</label>
                                <?= $this->Form->control('enderecos.0.logradouro', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small font-weight-bold text-dark">Nº Porta</label>
                                <?= $this->Form->control('enderecos.0.numero', ['class' => 'form-control border-left-primary', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">Bairro</label>
                                <?= $this->Form->control('enderecos.0.bairro', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">Complemento Estrutural</label>
                                <?= $this->Form->control('enderecos.0.complemento', ['class' => 'form-control text-muted', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-8 mb-3">
                                <label class="small font-weight-bold text-dark">Cidade Correspondente</label>
                                <?= $this->Form->control('enderecos.0.cidade', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark text-uppercase">U.F. (Estado)</label>
                                <?= $this->Form->control('enderecos.0.estado', [
                                    'class' => 'form-control custom-select', 
                                    'label' => false,
                                    'options' => [
                                        'AC'=>'AC', 'AL'=>'AL', 'AP'=>'AP', 'AM'=>'AM', 'BA'=>'BA', 'CE'=>'CE', 'DF'=>'DF', 'ES'=>'ES',
                                        'GO'=>'GO', 'MA'=>'MA', 'MT'=>'MT', 'MS'=>'MS', 'MG'=>'MG', 'PA'=>'PA', 'PB'=>'PB', 'PR'=>'PR',
                                        'PE'=>'PE', 'PI'=>'PI', 'RJ'=>'RJ', 'RN'=>'RN', 'RS'=>'RS', 'RO'=>'RO', 'RR'=>'RR', 'SC'=>'SC',
                                        'SP'=>'SP', 'SE'=>'SE', 'TO'=>'TO'
                                    ],
                                    'empty' => 'Sigla'
                                ]) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Aba: Escolaridade => ID = pills-escolaridade -->
                    <div class="tab-pane fade" id="pills-escolaridade" role="tabpanel" aria-labelledby="pills-escolaridade-tab">
                        <h5 class="text-dark font-weight-bold border-bottom pb-3 mb-4">Instrução Pedagógica Atual</h5>
                        <?= $this->Form->hidden('escolaridades.0.id') ?>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-dark">Grau Acadêmico / Nível</label>
                                <?= $this->Form->control('escolaridades.0.nivel', [
                                    'class' => 'form-control custom-select border-left-info',
                                    'label' => false,
                                    'options' => [
                                        'Fundamental' => __('Ensino Fundamental'),
                                        'Medio' => __('Ensino Médio'),
                                        'Tecnico' => __('Curso Técnico'),                            
                                        'Superior' => __('Ensino Superior'),                            
                                        'Pos-graduacao' => __('Pós-graduação'),                            
                                        'Mestrado' => __('Mestrado'),                            
                                        'Doutorado' => __('Doutorado'),                            
                                    ],
                                    'empty' => 'Sem Especificar'
                                ]) ?>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="small font-weight-bold text-dark">Status de Andamento</label>
                                <?= $this->Form->control('escolaridades.0.situacao', [
                                    'class' => 'form-control custom-select border-left-warning',
                                    'label' => false,
                                    'options' => [
                                        'Cursando' => __('Ativamente Cursando'),
                                        'Interrompido' => __('Interrompido / Congelado'),
                                        'Concluido' => __('Completamente Concluído'),                            
                                    ],
                                    'empty' => 'Informe a Situação'
                                ]) ?>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-8 mb-3">
                                <label class="small font-weight-bold text-dark">Instituição Ofertante da Aula</label>
                                <?= $this->Form->control('escolaridades.0.instituicao', ['class' => 'form-control', 'label' => false]) ?>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="small font-weight-bold text-dark">Ano da Graduação</label>
                                <?= $this->Form->control('escolaridades.0.ano_conclusao', ['class' => 'form-control bg-light', 'label' => false]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">Curso (se superior/técnico)</label>
                                <?= $this->Form->control('escolaridades.0.curso', ['class' => 'form-control text-primary font-weight-bold', 'label' => false]) ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small font-weight-bold text-dark">Ano Cursado / Série</label>
                                <?= $this->Form->control('escolaridades.0.serie', ['class' => 'form-control text-primary font-weight-bold', 'label' => false]) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 mt-5">
                <div class="d-flex justify-content-end align-items-center">
                    <span class="text-muted small me-4"><i class="fas fa-exclamation-triangle text-warning me-1"></i> As mudanças refletirão em toda a plataforma.</span>
                    <?= $this->Form->button('<i class="fas fa-sync-alt me-2"></i> ' . __('Efetivar Reajustes'), ['class' => 'btn btn-primary btn-lg shadow-sm px-5 ml-4', 'escapeTitle' => false]) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof $ !== 'undefined' && $.fn.mask) {
            $('.mascara-cpf').mask('000.000.000-00', {reverse: true});
            $('.mascara-cep').mask('00000-000');
            
            var behavior = function (val) {
              return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
            },
            options = {
              onKeyPress: function (val, e, field, options) {
                  field.mask(behavior.apply({}, arguments), options);
              }
            };
            $('.mascara-telefone').mask(behavior, options);
        }
    });

    $('.nav-pills a').on('click', function (e) {
        e.preventDefault()
        $(this).tab('show')
    })
</script>