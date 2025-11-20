<!-- BANNER
        ================================================== -->
<section class="p-0 top-position1">
    <div class="slider-fade owl-carousel owl-theme w-100">
        <div class="text-start item bg-img cover-background pt-6 pb-14 py-md-16 py-lg-20 py-xxl-24 rounded-lg left-overlay-dark"
            data-overlay-dark="1" data-background="<?= WWW; ?>/site/img/banner/slide-03.webp">
            <div class="container pt-6 pt-md-0">
                <div class="row align-items-center">
                    <div class="col-md-10 col-lg-8 col-xl-7 col-xxl-6 mb-1-9 mb-lg-0 py-5">
                        <span
                            class="text-primary display-21 display-sm-19 display-md-17 display-lg-8 mb-4">Desenvolvimento</span>
                        <h1
                            class="text-white display-16 display-md-9 display-lg-7 display-xl-4 mb-1-6 font-weight-700 text-shadow">
                            Social com
                            Sustentabilidade</h1>
                        <p class="text-white mb-2-3 opacity8 display-md-28 w-lg-80"></p>

                    </div>
                </div>
            </div>
        </div>
        <div class="text-start item bg-img cover-background pt-6 pb-14 py-md-16 py-lg-20 py-xxl-24 rounded-lg left-overlay-dark"
            data-overlay-dark="85" data-background="<?= WWW; ?>/site/img/banner/slide-04.webp">
            <div class="container pt-6 pt-md-0">
                <div class="row align-items-center">
                    <div class="col-md-10 col-lg-8 col-xl-7 col-xxl-6 mb-1-9 mb-lg-0 py-5">
                        <span class="text-primary display-21 display-sm-19 display-md-17 display-lg-8 mb-4">Valorizamos
                            a colaboração </span>
                        <h1
                            class="text-white display-16 display-md-9 display-lg-7 display-xl-4 mb-1-6 font-weight-700 text-shadow">
                            Para melhorar a vida dos cidadãos.</h1>
                        <p class="text-white mb-2-3 opacity8 display-md-28 w-lg-80"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- LOGO
        ================================================== -->
<section class="p-0">
    <div class="container">
        <div class="processo">
            <div class="row">
                <div class="col-auto text-center" style="margin-left: 186px;">
                    <img src="<?= WWW; ?>/site/img/avatar/avatar-02.png" alt="Logo do Instituto Ambienet" class="img-fluid"
                        style="width: 450px; height: auto;">
                    <div class="mt-3">
                        <!-- Conteúdo adicional aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- INSCRIÇÕES
        ================================================== -->
<section>
    <div class="container">
        <div class="row align-items-center mb-1-9 mb-lg-6 wow fadeIn" data-wow-delay="100ms">
            <div class="col-lg-5 mb-3 mb-lg-0">
                <span class="d-block mb-2 text-secondary text-uppercase fw-bold">Editais</span>
                <h2 class="mb-0">Confira nossos cursos disponíveis</h2>
            </div>
            <div class="col-lg-7">
                <p class="mb-0 border-lg-start border-width-4 border-secondary-color py-lg-4 ps-lg-6">O Instituto
                    Ambient tem experiência na realização de diagnósticos para atender as necessidades de seus
                    parceiros. Para estimular a consciência cidadã, a educação e melhorar a qualidade de vida dos
                    brasileiros, realiza ações diversas.</p>
            </div>
        </div>
        <div class="row mt-n1-9">
            <?php foreach ($postsEditais as $i => $post): ?>
                <?php
                $delay = ($i + 1) * 200; // Atraso animado crescente: 200ms, 400ms, etc.
                $featuredImage = null;
                foreach ($post->post_images as $img) {
                    if ($img->is_featured) {
                        $featuredImage = $img;
                        break;
                    }
                }

                $imagePath = $featuredImage
                    ? $this->Url->build('/img/uploads/' . $featuredImage->filename)
                    : $this->Url->build('/site/img/blog/blog-default.jpg');
                ?>
                <div class="col-sm-6 col-lg-3 mt-1-9 wow fadeIn" data-wow-delay="<?= $delay ?>ms">
                    <div class="card card-style3 border-0 text-center">
                        <a href="<?= $this->Url->build(h($post->excerpt)) ?>" class="text-decoration-none text-dark">
                            <div class="card-img position-relative">
                                <img src="<?= $imagePath ?>" class="card-img-top" alt="<?= h($post->title) ?>">

                            </div>
                        </a>
                        <div class="card-body p-1-9">
                            <h3 class="h5"><?= h($post->title) ?></h3>
                            <p class="text-primary mb-0">
                                <?= $post->content ?? 'Sem descrição' ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<!-- TESTEMUNHOS
        ================================================== -->
<section class="z-index-9">
    <div class="bg-img section-bg" data-overlay-dark="6" data-background="<?= WWW; ?>/site/img/bg/bg-02.jpg"></div>
    <div class="container position-relative z-index-9">
        <div class="mb-2-6 mb-lg-6 text-center wow fadeIn" data-wow-delay="100ms">
            <span class="d-block mb-2 text-white text-uppercase fw-bold">Testemunhos</span>
            <h2 class="text-white mb-0 h1">O que as pessoas estão falando do Instituto Ambient?</h2>
        </div>
        <div class="bg-primary p-1-9 p-lg-6 testimonial-style1 position-relative rounded wow fadeIn"
            data-wow-delay="200ms">
            <img src="<?= WWW; ?>/site/img/content/dots2.png"
                class="position-absolute bottom-n60 right-n10 ani-left-right" alt="...">
            <div class="testimonial-carousel owl-carousel owl-theme">
                <div class="text-center row justify-content-center">
                    <div class="col-md-10">
                        <img src="site/img/avatar/avatar-01.jpg" alt="Aspas" class="text-white display-3" width="50">
                        <p class="mb-1-6 text-center mt-3 mt-lg-2-3 lead text-white">O Instituto Ambient foi uma
                            experiência transformadora para mim! Participei de um curso de educação ambiental e aprendi
                            muito sobre sustentabilidade e conservação da natureza. Os professores são extremamente
                            capacitados e apaixonados pelo que fazem. Sem dúvida, foi um aprendizado que levarei para a
                            vida toda!</p>
                        <h6 class="mb-1 text-white font-weight-400">Ana Paula S.</h6>
                        <p class="mb-0 text-white opacity8 small">Estudante de Biologia</p>
                    </div>
                </div>
                <div class="text-center row justify-content-center">
                    <div class="col-md-10">
                        <img src="site/img/avatar/avatar-01.jpg" alt="Aspas" class="text-white display-3" width="50">
                        <p class="mb-1-6 text-center mt-3 mt-lg-2-3 lead text-white">Conheci o Instituto Ambient
                            através de um projeto de responsabilidade socioambiental da minha empresa, e fiquei
                            impressionado com o impacto positivo que eles geram. O trabalho deles na conscientização
                            ecológica e preservação do meio ambiente é essencial. Recomendo para qualquer empresa ou
                            pessoa que queira fazer a diferença!</p>
                        <h6 class="mb-1 text-white font-weight-400">Carlos M</h6>
                        <p class="mb-0 text-white opacity8 small">Empresário</p>
                    </div>
                </div>
                <div class="text-center row justify-content-center">
                    <div class="col-md-10">
                        <img src="site/img/avatar/avatar-01.jpg" alt="Aspas" class="text-white display-3" width="50">
                        <p class="mb-1-6 text-center mt-3 mt-lg-2-3 lead text-white">Ser voluntária no Instituto
                            Ambient foi uma das melhores decisões da minha vida. O ambiente é acolhedor, e cada projeto
                            tem um impacto real na comunidade. Aprendi sobre reciclagem, reflorestamento e educação
                            ambiental, além de conhecer pessoas incríveis que compartilham o mesmo propósito. Sou muito
                            grata por fazer parte dessa missão!</p>
                        <h6 class="mb-1 text-white font-weight-400">Mariana R. </h6>
                        <p class="mb-0 text-white opacity8 small">Voluntária</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BLOG ================================================== -->
<section class="pt-0">
    <div class="container">
        <div class="row align-items-center mb-1-9 mb-lg-6 wow fadeIn" data-wow-delay="100ms">
            <div class="col-lg-5 mb-3 mb-lg-0">
                <span class="d-block mb-2 text-secondary text-uppercase fw-bold">Notícias em Destaque</span>
                <h2 class="mb-0">Fique por dentro das últimas novidades sobre meio ambiente, sustentabilidade e ações
                    ecológicas!</h2>
            </div>
            <div class="col-lg-7">
                <p class="mb-0 border-lg-start border-width-4 border-secondary-color py-lg-4 ps-lg-6">No Instituto
                    Ambient, trazemos informações atualizadas sobre projetos ambientais, eventos, pesquisas e
                    iniciativas que fazem a diferença. Acompanhe nossas notícias e contribua para um futuro mais
                    sustentável!</p>
            </div>
        </div>
        <div class="row mt-n1-9 g-xl-5">
            <?php foreach ($postsNoticias as $post): ?>
                <div class="col-md-6 col-lg-4 mt-1-9 wow fadeIn" data-wow-delay="200ms">
                    <article class="card card-style3 border-0 h-100 shadow-sm position-relative">
                        <div class="card-img position-relative">
                            <?php
                            $featuredImage = null;
                            foreach ($post->post_images as $img) {
                                if ($img->is_featured) {
                                    $featuredImage = $img;
                                    break;
                                }
                            }
                            ?>
                            <?php if ($featuredImage): ?>
                                <img src="<?= $this->Url->build('/img/uploads/' . $featuredImage->filename) ?>"
                                    alt="<?= h($post->title) ?>" class="img-fluid rounded-top">
                            <?php else: ?>
                                <img src="<?= $this->Url->build('/site/img/avatar/avatar-02.png') ?>"
                                    alt="Imagem padrão" class="img-fluid rounded-top">
                            <?php endif; ?>
                        </div>

                        <div class="card-body p-xl-1-9 p-4">
                            <h3 class="h5 mb-3"><?= h($post->title) ?></h3>
                            <p class="fw-bold text-primary text-secondary-hover">Saiba mais</p>

                            <!-- link estendido que cobre todo o card -->
                            <a href="<?= $this->Url->build('/posts/view/' . h($post->slug)) ?>"
                                class="stretched-link"
                                aria-label="Abrir postagem: <?= h($post->title) ?>"></a>
                        </div>

                        <div class="card-footer bg-white py-4 px-0 mx-4 mx-xl-1-9 border-0">
                            <div class="d-flex justify-content-between">
                                <span class="display-30">
                                    <i class="ti-calendar me-1 text-primary"></i>
                                    <?= $post->published
                                        ? $post->published->i18nFormat("d 'de' MMMM 'de' yyyy", null, 'pt_BR')
                                        : '' ?>
                                </span>
                            </div>
                        </div>
                    </article>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- PAREIROS
        ================================================== -->
<section id="features" class="core-features-section bg-light">
    <div class="px-1-6 px-md-6 px-lg-7 px-xl-14 px-xxl-22">
        <div class="text-center mb-6 mb-lg-8">
            <h2 class="mb-0">Nossos Parceiros</h2>
        </div>
        <div class="row">
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-10.png" class="mb-3" alt="GRUPO EQUATORIAL">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-11.png" class="mb-3"
                            alt="SUZUNO">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-12.png" class="mb-3" alt="ELO">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-4.png" class="mb-3" alt="FUNDAÇÃO ACOLHER">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-5.png" class="mb-3"
                            alt="MINISTERIO PÚBLICO DO TRABALHO">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-6.png" class="mb-3"
                            alt="MINISTERIO PÚBLICO DO ESTADO DO PARA">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-7.png" class="mb-3"
                            alt="TRIBUNAL DE JUSTIÇA DO ESTADO DO PARÁ">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-8.png" class="mb-3" alt="FUNDAÇÃO PAPA JOÃO XXIII">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-9.png" class="mb-3" alt="CONSELHO TUTELAR DE BELÉM">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-1.png" class="mb-3" alt="COMDAC">

                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-lg-3 col-xxl-2 mt-2-9">
                <div class="card card-features d-table border-0 text-center">
                    <div class="card-body d-table-cell py-2-2 align-middle">
                        <img src="<?= WWW; ?>/site/img/icons/icon-3.png" class="mb-3" alt="PERNOH">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>