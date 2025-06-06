<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var array $atividades // Adicionei esta variável para garantir que o array de atividades está disponível
 */
?>
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/bg/bg-07.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Adicionar Novo Aluno</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="#!">Adicionar Aluno</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-xl-4 mb-2-9 mb-lg-0">
                <div class="pe-lg-3 mt-n1-9">
                    <div class="card card-style8 mt-1-9">
                        <div class="card-body p-1-9">
                            <div class="media">
                                <div class="icon-box">
                                    <i class="ti-info-alt text-primary z-index-9 position-relative"></i>
                                    <div class="box-circle primary"></div>
                                </div>
                                <div class="media-body">
                                    <h4 class="h5">Dicas para Cadastro</h4>
                                    <span>Preencha todos os campos com atenção para garantir a inscrição correta do
                                        aluno.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-style8 mt-1-9">
                        <div class="card-body p-1-9">
                            <div class="media">
                                <div class="icon-box">
                                    <i class="ti-clip text-primary z-index-9 position-relative"></i>
                                    <div class="box-circle primary"></div>
                                </div>
                                <div class="media-body">
                                    <h4 class="h5">Documentos Necessários</h4>
                                    <span class="d-block">CPF e RG do aluno (ou responsável, se menor).</span>
                                    <span>Comprovante de residência.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-xl-8">
                <div class="contact-form p-4 p-md-5 ms-xl-3">
                    <h2 class="h3 mb-4">Adicionar Novo Aluno</h2>
                    <div class="alunos form content">
                        <?= $this->Form->create($aluno) ?>
                        <?= $this->Flash->render() ?>
                        <?php if ($aluno->getErrors()): ?>
                            <div class="alert alert-danger">
                                <h5>Erros de validação:</h5>
                                <ul>
                                    <?php foreach ($aluno->getErrors() as $field => $errors): ?>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= h($field) ?>: <?= h($error) ?></li>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <!-- Dados Pessoais (sempre exibe na 1ª etapa) -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">Dados Pessoais</h5>
                            </div>
                            <div class="card-body">
                                <?= $this->Form->control('user_id', ['type' => 'hidden', 'value' => '11']) ?>
                                <?= $this->Form->control('nome_completo', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('data_nascimento', ['type' => 'date', 'class' => 'form-control']) ?>
                                <?= $this->Form->control('email', ['type' => 'email', 'class' => 'form-control']) ?>
                                <?= $this->Form->control('telefone', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('genero', [
                                    'class' => 'form-control',
                                    'label' => 'Gênero',
                                    'options' => [
                                        'masculino' => 'Masculino',
                                        'Feminino' => 'Feminino',
                                        'Nao_informado' => 'Não informado',
                                        'Nao_Binario' => 'Não Binário',
                                    ]
                                ]) ?>
                                <?= $this->Form->control('civil', [
                                    'class' => 'form-control',
                                    'label' => 'Estado Civil',
                                    'options' => [
                                        'Casado' => 'Casado(a)',
                                        'Divorciado' => 'Divorciado(a)',
                                        'Solteiro' => 'Solteiro(a)',
                                        'Uniao_estavel' => 'União Estável',
                                        'Viuvo' => 'Viúvo(a)',
                                    ]
                                ]) ?>
                                <?= $this->Form->control('religiao', [
                                    'class' => 'form-control',
                                    'label' => 'Qual a sua religião?',
                                    'options' => [
                                        'Adventista' => 'Adventista',
                                        'Budista' => 'Budista',
                                        'Candomble' => 'Candomblé',
                                        'Catolica' => 'Católica',
                                        'Evangelica' => 'Evangélica',
                                        'Islamica' => 'Islâmica',
                                        'Mormon' => 'Mórmon',
                                        'Nao_possui' => 'Não possui',
                                    ]
                                ]) ?>
                                <?= $this->Form->control('naturalidade', [
                                    'type' => 'select',
                                    'label' => 'Naturalidade',
                                    'options' => [
                                        'Para' => 'PARÁ',
                                        'Outro' => 'Outro',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-naturalidade'
                                ]) ?>

                                <div id="campo-outra-naturalidade" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('outra_naturalidade', [
                                        'label' => 'Informe sua naturalidade',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>
                                <?= $this->Form->control('nacionalidade', [
                                    'type' => 'select',
                                    'label' => 'Nacionalidade',
                                    'options' => [
                                        'Brasileira' => 'Brasileira',
                                        'Outro' => 'Outro',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-nacionalidade'
                                ]) ?>
                                <div id="campo-outra-nacionalidade" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('outra_nacionalidade', [
                                        'label' => 'Informe sua nacionalidade',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <?= $this->Form->control('Etnia', [
                                    'class' => 'form-control',
                                    'label' => 'Cor/Etnia',
                                    'options' => [
                                        'Parda' => 'Parda',
                                        'Preta' => 'Preta',
                                        'Indigena' => 'Indígena',
                                    ]
                                ]) ?>

                                <?= $this->Form->control('programas_sociais', [
                                    'type' => 'select',
                                    'label' => 'Programas Sociais em que é incluído:',
                                    'options' => [
                                        'boisa_familia' => 'Programa Bolsa Família',
                                        'bpc' => 'Benefício de Prestação Continuada- BPC',
                                        'cartao_alimentação' => 'Cartão alimentação',
                                        'nenhum' => 'Nenhum',
                                        'Outro' => 'Outro',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-programas-sociais'
                                ]) ?>
                                <div id="campo-outra-programas-sociais" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('outra_programas-sociais', [
                                        'label' => 'Informe outro Programa Social',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <?= $this->Form->control('valor_do_beneficio', ['class' => 'form-control', 'label' => 'Qual o valor do benefício?']) ?>

                                <?= $this->Form->control('deficiencia', [
                                    'type' => 'select',
                                    'label' => 'Pessoa com Deficiência?',
                                    'options' => [
                                        'nao' => 'Não',
                                        'Outro' => 'Sim',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-deficiencia'
                                ]) ?>
                                <div id="campo-outra-deficiencia" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('outra_deficiencia', [
                                        'label' => 'Qual a sua Deficiência?',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>

                                <?= $this->Form->control('encaminhado_instituicao', [
                                    'type' => 'select',
                                    'label' => 'Você foi encaminhado(a) de alguma dessas Instituições',
                                    'options' => [
                                        'caps' => 'CAPS',
                                        'cras_creas' => 'CRAS/CREAS',
                                        'deam' => 'DELEGACIA DA MULHER (DEAM)',
                                        'escola_puplica' => 'ESCOLA PÚBLICA',
                                        'unidade_de_saudeE' => 'UNIDADE DE SAÚDE',
                                        'poser_judiciario' => 'PODER JUDICIÁRIO',
                                        'Outro' => 'Outra',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-instituicao-encaminhado'
                                ]) ?>
                                <div id="campo-outra-instituicao-encaminhado" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('outra_instituicao_encaminhado', [
                                        'label' => 'Qual a Instituição?',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>
                            </div>
                        </div>


                        <!-- Documentos Pessoais (sempre exibe na 2ª etapa) -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">Documetos Pessoais</h5>
                            </div>
                            <div class="card-body">
                                <?= $this->Form->control('cpf', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('rg', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('nis', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('documentos_civis', [
                                    'class' => 'form-control',
                                    'label' => 'Selecione quais dos documentos civis abaixo você possui',
                                    'options' => [
                                        'c_nascimento' => 'Certidão de nascimento',
                                        'c_casamento' => 'Certidão de casamento',
                                        'c_reservista' => 'Certificado de reservista',
                                        'c_trabalho' => 'Carteira de trabalho',
                                    ]
                                ]) ?>

                                <?= $this->Form->control('cadunico', ['class' => 'form-control', 'label' => 'Sua família está cadastrada no CadÚnico? ( se sim, digita o número do código familiar)']) ?>

                                <?= $this->Form->control('cadunico', [
                                    'type' => 'select',
                                    'label' => 'Sua família está cadastrada no CadÚnico?',
                                    'options' => [
                                        'nao' => 'Não',
                                        'Outro' => 'Sim',
                                    ],
                                    'class' => 'form-control select-com-outro',
                                    'data-target' => '#campo-outra-valor-cadunico'
                                ]) ?>
                                <div id="campo-outra-valor-cadunico" class="campo-outro" style="display:none;">
                                    <?= $this->Form->control('valor_cadunico', [
                                        'label' => 'Digita o número do código familiar?',
                                        'class' => 'form-control',
                                    ]) ?>
                                </div>s
                            </div>
                        </div>

                        <!-- Endereço -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">Endereço</h5>
                            </div>
                            <div class="card-body">
                                <?= $this->Form->hidden('enderecos.0.id') ?>
                                <?= $this->Form->control('enderecos.0.cep', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('enderecos.0.logradouro', ['class' => 'form-control', 'label' => 'Informe o seu endereço']) ?>
                                <?= $this->Form->control('enderecos.0.numero', ['class' => 'form-control', 'label' => 'Numero']) ?>
                                <?= $this->Form->control('enderecos.0.complemento', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('enderecos.0.bairro', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('enderecos.0.cidade', ['class' => 'form-control']) ?>
                            </div>
                        </div>

                        <!-- Escolaridade -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">Escolaridade</h5>
                            </div>
                            <div class="card-body">
                                <?= $this->Form->hidden('escolaridades.0.id') ?>
                                <?= $this->Form->control('escolaridades.0.nivel', [
                                    'class' => 'form-control',
                                    'options' => [
                                        'Fundamental' => 'Fundamental',
                                        'Medio' => 'Médio',
                                        'Tecnico' => 'Técnico',
                                        'Superior' => 'Superior',
                                        'Pos-graduacao' => 'Pós-graduação',
                                        'Mestrado' => 'Mestrado',
                                        'Doutorado' => 'Doutorado',
                                    ]
                                ]) ?>
                                <?= $this->Form->control('escolaridades.0.situacao', [
                                    'class' => 'form-control',
                                    'options' => [
                                        'Cursando' => 'Cursando',
                                        'Interrompido' => 'Interrompido',
                                        'Concluido' => 'Concluído',
                                    ]
                                ]) ?>
                                <?= $this->Form->control('escolaridades.0.instituicao', ['class' => 'form-control', 'label' => 'Informe o nome da instiuição que você estuda ou estudou']) ?>

                            </div>
                        </div>

                        <?= $this->Form->control('atividade_id', ['type' => 'hidden', 'value' => $atividade_id]) ?>

                        <?= $this->Form->button(__('Salvar Aluno'), ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selects = document.querySelectorAll('.select-com-outro');

        selects.forEach(function (select) {
            const targetId = select.getAttribute('data-target');
            const target = document.querySelector(targetId);

            const toggleCampoOutro = function () {
                if (select.value === 'Outro') {
                    target.style.display = 'block';
                } else {
                    target.style.display = 'none';
                }
            };

            // Executa ao carregar
            toggleCampoOutro();

            // Executa ao mudar
            select.addEventListener('change', toggleCampoOutro);
        });
    });
</script>