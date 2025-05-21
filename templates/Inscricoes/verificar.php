<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Verificar Inscrição</h1> </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="#!">Verificar Inscrição</a></li> </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-xl-8">
                <div class="contact-form p-4 p-md-5 ms-xl-3">
                    <h2 class="h3 mb-4">Verificar sua Inscrição</h2>
                    <div class="container">
                        <h1>Inscrição em: <?= h($atividade->nome) ?></h1>

                        <?= $this->Form->create() ?>
                            <?= $this->Form->control('cpf', ['label' => 'Seu CPF', 'required' => true , 'class' => 'form-control']) ?>
                            <?= $this->Form->control('data_nascimento', ['type' => 'date', 'label' => 'Data de Nascimento','required' => true ,'class' => 'form-control']) ?>
                            <?= $this->Form->button('Verificar Cadastro', ['class' => 'butn-style3 mt-3']) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</section>