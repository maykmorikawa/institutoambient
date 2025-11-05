<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="<?= WWW; ?>/site/img/banner/page-title.webp">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Contato</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="#!">Contato</a></li>
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
                                    <i class="ti-location-pin text-primary z-index-9 position-relative"></i>
                                    <div class="box-circle primary"></div>
                                </div>
                                <div class="media-body">
                                    <h4 class="h5">Localização</h4>
                                    <span>Av. Dr. Freitas, 55 - Sacramenta, Belém - PA, 66123-050</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-style8 mt-1-9">
                        <div class="card-body p-1-9">
                            <div class="media">
                                <div class="icon-box">
                                    <i class="ti-mobile text-primary z-index-9 position-relative"></i>
                                    <div class="box-circle primary"></div>
                                </div>
                                <div class="media-body">
                                    <h4 class="h5">Telefone</h4>
                                    <span class="d-block">(91) 3086-2129</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-style8 mt-1-9">
                        <div class="card-body p-1-9">
                            <div class="media">
                                <div class="icon-box">
                                    <i class="ti-email text-primary z-index-9 position-relative"></i>
                                    <div class="box-circle primary"></div>
                                </div>
                                <div class="media-body">
                                    <h4 class="h5">E-mail</h4>
                                    <span class="d-block">contato@institutoambient.org.br</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-xl-8">
                <div class="contact-form p-4 p-md-5 ms-xl-3">
                    <h2 class="h3 mb-4">Formulário Para Contato</h2>

                    <?= $this->Form->create(null, [
                        'url' => ['controller' => 'Contacts', 'action' => 'enviar'],
                        'type' => 'post',
                        'class' => 'quform',
                        'enctype' => 'multipart/form-data'
                    ]) ?>

                    <div class="quform-elements">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="quform-element form-group">
                                    <?= $this->Form->control('name', [
                                        'label' => 'Seu Nome <span class="quform-required">*</span>',
                                        'escape' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Seu nome aqui'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="quform-element form-group">
                                    <?= $this->Form->control('email', [
                                        'label' => 'Seu Email <span class="quform-required">*</span>',
                                        'escape' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Seu email aqui'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="quform-element form-group">
                                    <?= $this->Form->control('subject', [
                                        'label' => 'Seu Assunto <span class="quform-required">*</span>',
                                        'escape' => false,
                                        'class' => 'form-control',
                                        'placeholder' => 'Seu assunto aqui'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="quform-element form-group">
                                    <?= $this->Form->control('phone', [
                                        'label' => 'Seu Número de Contato',
                                        'class' => 'form-control',
                                        'placeholder' => 'Seu telefone aqui'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="quform-element form-group">
                                    <?= $this->Form->control('message', [
                                        'type' => 'textarea',
                                        'label' => 'Mensagem <span class="quform-required">*</span>',
                                        'escape' => false,
                                        'class' => 'form-control h-auto',
                                        'rows' => 3,
                                        'placeholder' => 'Diga-nos algumas palavras'
                                    ]) ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="quform-submit-inner">
                                    <?= $this->Form->button('<span>Enviar Mensagem</span>', [
                                        'class' => 'butn-style3',
                                        'escapeTitle' => false
                                    ]) ?>
                                </div>
                                <div class="quform-loading-wrap text-start">
                                    <span class="quform-loading"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

        </div>
    </div>
</section>

<iframe class="map" id="gmap_canvas" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d249.28795043570457!2d-48.472912722671936!3d-1.4117716490946033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x92a48bff1cccc119%3A0x8b7cc84faaba4d48!2sInstituto%20Ambient!5e0!3m2!1spt-BR!2sbr!4v1762305750546!5m2!1spt-BR!2sbr" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen=""></iframe>