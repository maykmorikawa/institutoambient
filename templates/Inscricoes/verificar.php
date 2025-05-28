<style>
    /* Flash messages */
.message {
    padding: .5rem 1rem;
    background: var(--color-message-info-bg);
    color: var(--color-message-info-text);
    border-color: var(--color-message-info-border);
    border-width: 1px;
    border-style: solid;
    border-radius: 4px;
    margin-bottom: 1rem;
    cursor: pointer;
}
.message.hidden {
    display: none;
}
.message.success {
    background: var(--color-message-success-bg);
    color: var(--color-message-success-text);
    border-color: var(--color-message-success-border);
}
.message.warning {
    background: var(--color-message-warning-bg);
    color: var(--color-message-warning-text);
    border-color: var(--color-message-warning-border);
}
.message.error {
    background: var(--color-message-error-bg);
    color: var(--color-message-error-text);
    border-color: var(--color-message-error-border);
}
</style>
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
                         <?= $this->Flash->render() ?>
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