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
                        <?= $this->Flash->render() ?>
                        <?= $this->Form->create($aluno) ?>
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
                                <?= $this->Form->control('email', ['type' => 'email', 'class' => 'form-control']) ?>
                                <?= $this->Form->control('cpf', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('rg', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('nis', ['class' => 'form-control']) ?>
                                <?= $this->Form->control('data_nascimento', ['type' => 'date', 'class' => 'form-control']) ?>
                                <?= $this->Form->control('telefone', ['class' => 'form-control']) ?>
                            </div>
                        </div>

                        <?php if ($aluno_id): ?>
                            <!-- Endereço -->
                            <div class="card mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0 text-white">Endereço</h5>
                                </div>
                                <div class="card-body">
                                    <?= $this->Form->hidden('enderecos.0.id') ?>
                                    <?= $this->Form->control('enderecos.0.cep', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.logradouro', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.numero', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.complemento', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.bairro', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.cidade', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('enderecos.0.estado', ['class' => 'form-control']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($aluno_id && !empty($aluno->enderecos)): ?>
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
                                    <?= $this->Form->control('escolaridades.0.serie', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('escolaridades.0.situacao', [
                                        'class' => 'form-control',
                                        'options' => [
                                            'Cursando' => 'Cursando',
                                            'Interrompido' => 'Interrompido',
                                            'Concluido' => 'Concluído',
                                        ]
                                    ]) ?>
                                    <?= $this->Form->control('escolaridades.0.curso', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('escolaridades.0.instituicao', ['class' => 'form-control']) ?>
                                    <?= $this->Form->control('escolaridades.0.ano_conclusao', ['class' => 'form-control']) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?= $this->Form->control('atividade_id', ['type' => 'hidden', 'value' => $atividade_id]) ?>

                        <?= $this->Form->button(__('Salvar Aluno'), ['class' => 'btn btn-primary']) ?>
                        <?= $this->Form->end() ?>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>