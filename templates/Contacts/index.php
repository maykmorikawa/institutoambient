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

                <?= $this->Flash->render() ?>

                <?= $this->Form->create(null, [
                    'url' => ['controller' => 'Contacts', 'action' => 'enviar'],
                    'method' => 'post',
                    'class' => 'contact-form-cakephp',
                ]) ?>

                <div class="quform-elements">
                    <div class="row">

                        <!-- Nome -->
                        <div class="col-md-6">
                            <div class="quform-element form-group">
                                <?= $this->Form->control('name', [
                                    'label' => 'Seu Nome <span class="quform-required">*</span>',
                                    'escape' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Seu nome aqui',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <div class="quform-element form-group">
                                <?= $this->Form->control('email', [
                                    'label' => 'Seu Email <span class="quform-required">*</span>',
                                    'escape' => false,
                                    'class' => 'form-control',
                                    'placeholder' => 'Seu email aqui',
                                    'type' => 'email',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <!-- Assunto (Select) -->
                        <div class="col-md-6">
                            <div class="quform-element form-group">
                                <?= $this->Form->control('subject', [
                                    'type' => 'select',
                                    'label' => 'Assunto <span class="quform-required">*</span>',
                                    'escape' => false,
                                    'class' => 'form-control',
                                    'empty' => 'Selecione um assunto',
                                    'options' => [
                                        'informativos' => 'Informativos',
                                        'boletim'      => 'Boletim – Últimas Notícias',
                                        'parcerias'    => 'Parcerias',
                                        'eventos'      => 'Eventos',
                                        'outros'       => 'Outros'
                                    ],
                                    'id' => 'subject-select',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <!-- Telefone -->
                        <div class="col-md-6">
                            <div class="quform-element form-group">
                                <?= $this->Form->control('phone', [
                                    'label' => 'Seu Número de Contato',
                                    'class' => 'form-control',
                                    'placeholder' => '(00) 00000-0000'
                                ]) ?>
                            </div>
                        </div>

                        <!-- Mensagem -->
                        <div class="col-md-12">
                            <div class="quform-element form-group">
                                <?= $this->Form->control('message', [
                                    'type' => 'textarea',
                                    'label' => 'Mensagem <span class="quform-required">*</span>',
                                    'escape' => false,
                                    'class' => 'form-control h-auto',
                                    'rows' => 4,
                                    'placeholder' => 'Diga-nos algumas palavras',
                                    'id' => 'message-textarea',
                                    'required' => true
                                ]) ?>
                            </div>
                        </div>

                        <!-- Botão -->
                        <div class="col-md-12">
                            <div class="quform-submit-inner">
                                <?= $this->Form->button('<span>Enviar Mensagem</span>', [
                                    'class' => 'butn-style3',
                                    'escapeTitle' => false
                                ]) ?>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const subject = document.getElementById('subject-select');
        const message = document.getElementById('message-textarea');

        const templates = {
            informativos: 'Olá, gostaria de receber mais informações sobre os informativos do Instituto.\n\n',
            boletim: 'Olá, gostaria de receber o boletim com as últimas notícias do Instituto.\n\n',
            parcerias: 'Olá, tenho interesse em conversar sobre possíveis parcerias com o Instituto.\n\n',
            eventos: 'Olá, gostaria de saber mais sobre os próximos eventos do Instituto.\n\n',
            outros: 'Olá, gostaria de tratar do seguinte assunto:\n\n'
        };

        subject.addEventListener('change', () => {
            const value = subject.value;
            message.value = templates[value] ?? '';
            message.focus();
        });
    });
</script>
