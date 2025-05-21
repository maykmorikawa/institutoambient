<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>

<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', ['block' => true]) ?>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', ['block' => true]) ?>

<div class="row">
    <div class="col-md-12">
        <?= $this->Form->create($aluno) ?>

        <ul class="nav nav-tabs" id="alunoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="dados-tab" data-bs-toggle="tab" data-bs-target="#dados" type="button" role="tab">Dados Pessoais</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="endereco-tab" data-bs-toggle="tab" data-bs-target="#endereco" type="button" role="tab">Endereço</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="escolaridade-tab" data-bs-toggle="tab" data-bs-target="#escolaridade" type="button" role="tab">Escolaridade</button>
            </li>
        </ul>

        <div class="tab-content p-3 border border-top-0">
            <!-- Tab Dados Pessoais -->
            <div class="tab-pane fade show active" id="dados" role="tabpanel">
                <div class="mb-3">
                    <?= $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'label' => 'Usuário']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('nome_completo', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('email', ['type' => 'email', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('cpf', [
                        'class' => 'form-control',
                        'id' => 'cpf',
                        'placeholder' => '___.___.___-__'
                    ]) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('rg', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('nis', ['class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('data_nascimento', ['type' => 'date', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('telefone', [
                        'class' => 'form-control',
                        'id' => 'telefone',
                        'placeholder' => '(  ) ____-____'
                    ]) ?>
                </div>
            </div>

            <!-- Tab Endereço -->
            <div class="tab-pane fade" id="endereco" role="tabpanel">
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.cep', ['label' => 'CEP', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.logradouro', ['label' => 'Logradouro', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.numero', ['label' => 'Número', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.complemento', ['label' => 'Complemento', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.bairro', ['label' => 'Bairro', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.cidade', ['label' => 'Cidade', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('enderecos.0.estado', ['label' => 'Estado', 'class' => 'form-control']) ?>
                </div>
            </div>

            <!-- Tab Escolaridade -->
            <div class="tab-pane fade" id="escolaridade" role="tabpanel">
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.nivel', [
                        'class' => 'form-control',
                        'label' => 'Nível',
                        'options' => [
                            'Fundamental' => __('Fundamental'),
                            'Medio' => __('Médio'),
                            'Tecnico' => __('Técnico'),                            
                            'Superior' => __('Superior'),                            
                            'Pos-graduacao' => __('Pós-graduação'),                            
                            'Mestrado' => __('Mestrado'),                            
                            'Doutorado' => __('Doutorado'),                            
                        ],
                    ]) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.serie', ['label' => 'Série', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.situacao', [
                        'class' => 'form-control',
                        'label' => 'Situação',
                        'options' => [
                            'Cursando' => __('Cursando'),
                            'Interrompido' => __('Interrompido'),
                            'Concluido' => __('Concluído'),                            
                        ],
                    ]) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.curso', ['label' => 'Curso', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.instituicao', ['label' => 'Instituição', 'class' => 'form-control']) ?>
                </div>
                <div class="mb-3">
                    <?= $this->Form->control('escolaridades.0.ano_conclusao', ['label' => 'Ano de Conclusão', 'class' => 'form-control']) ?>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Máscara para CPF
        $('#cpf').mask('000.000.000-00', {
            reverse: true
        });

        // Máscara para telefone (ajusta automaticamente para celular ou fixo)
        $('#telefone').keydown(function() {
            var telefone = $(this).val().replace(/\D/g, '');
            if (telefone.length > 10) {
                $(this).mask('(00) 00000-0000');
            } else {
                $(this).mask('(00) 0000-00009');
            }
        }).trigger('keydown');
    });
</script>