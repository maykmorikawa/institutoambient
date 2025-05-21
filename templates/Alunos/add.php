<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
</fieldset>
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="img/banner/page-title.jpg">
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
                        <fieldset>
                            <legend class="h5 mb-3"><?= __('Dados do Aluno') ?></legend>
                            <?php
                            echo $this->Form->control('user_id', ['options' => $users, 'label' => 'Usuário Responsável', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('nome_completo', ['label' => 'Nome Completo', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('email', ['label' => 'E-mail', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('cpf', ['label' => 'CPF', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('rg', ['label' => 'RG', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('nis', ['label' => 'NIS', 'class' => 'form-control mb-3']);
                            echo $this->Form->control('data_nascimento', ['type' => 'date', 'label' => 'Data de Nascimento', 'empty' => true, 'class' => 'form-control mb-3']);
                            echo $this->Form->control('telefone', ['label' => 'Telefone', 'class' => 'form-control mb-3']);

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
                        </fieldset>
                        <?= $this->Form->button(__('Cadastrar Aluno'), ['class' => 'butn-style3 mt-4']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>
</div>
</div>