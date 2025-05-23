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

                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Dados Pessoais</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <?= $this->Form->control('user_id', ['options' => $users, 'class' => 'form-control', 'label' => 'Usuário Responsável']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('nome_completo', ['class' => 'form-control', 'label' => 'Nome Completo']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('email', ['type' => 'email', 'class' => 'form-control', 'label' => 'E-mail']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('cpf', ['class' => 'form-control', 'label' => 'CPF']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('rg', ['class' => 'form-control', 'label' => 'RG']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('nis', ['class' => 'form-control', 'label' => 'NIS']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('data_nascimento', ['type' => 'date', 'class' => 'form-control', 'label' => 'Data de Nascimento']) ?>
                                </div>
                                <div class="mb-3">
                                    <?= $this->Form->control('telefone', ['class' => 'form-control', 'label' => 'Telefone']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Endereço</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($aluno->enderecos)): ?>
                                    <?= $this->Form->hidden('enderecos.0.id') ?>
                                <?php endif; ?>
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
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">Escolaridade</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($aluno->escolaridades)): ?>
                                    <?= $this->Form->hidden('escolaridades.0.id') ?>
                                <?php endif; ?>
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

                        <?php
                            // Pega o atividade_id da URL
                            $atividadeId = $this->request->getQuery('atividade_id');
                        ?>

                        <?= $this->Form->control('atividade_id', [
                            'type' => 'hidden',
                            'value' => $atividadeId
                        ]) ?>

                        <p class="mt-4">
                            <strong>Atividade:</strong>
                            <?= h($atividades[$atividadeId] ?? 'Desconhecida') ?>
                        </p>

                        <?= $this->Form->button(__('Salvar Aluno'), ['class' => 'butn-style3 mt-4']) ?>
                        <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'butn-style3 mt-4 btn-secondary']) ?>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>