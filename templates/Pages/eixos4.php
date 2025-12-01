<?php
// Carrossel superior
$carouselSuperior = [
    'luminar.jpg',
];
?>
<!-- TOPO
================================================== -->
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.webp">

    <div class="container position-unset">

        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">

            <div class="row">

                <div class="col-md-12">

                    <h1>Eixo 04</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Eixo 04</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- Pressupostos Estratégicos
================================================== -->

<section class="aboutus">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-2-2 mb-lg-0 wow fadeIn" data-wow-delay="200ms">
                <div class="pe-lg-1-9 pe-xl-2-9 position-relative z-index-1">
                    
                   <div id="carouselSuperior" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-indicators">
                            <?php foreach ($carouselSuperior as $i => $img): ?>
                                <button type="button"
                                        data-bs-target="#carouselSuperior"
                                        data-bs-slide-to="<?= $i ?>"
                                        class="<?= $i === 0 ? 'active' : '' ?>"
                                        aria-label="Slide <?= $i + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>

                        <div class="carousel-inner">
                            <?php foreach ($carouselSuperior as $i => $img): ?>
                                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                    <img src="<?= WWW; ?>/site/img/about/<?= $img ?>" class="d-block w-100 rounded">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselSuperior" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselSuperior" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                    <div class="box-left py-4 px-4 px-sm-4 px-md-5" style="margin-bottom: -150px; left: -9px;">
                        <h3 class="text-secondary"><span class="countup">01</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Iniciativa de Autocuidado</p>
                    </div>
                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>
            
            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Qualidade de Vida e Cuidado Integral</span>
                    <h2 class="mb-1-6">EIXO 04: SAÚDE E BEM-ESTAR</h2>
                    <p class="fst-italic font-weight-600">
                        **OBJETIVO ESTRATÉGICO:** Proporcionar noções de cuidados de forma integrativa, promovendo a qualidade de vida, o bem-estar físico e mental dos nossos beneficiários.
                    </p>
                    
                    <p>
                        O Eixo 04 promove o **autocuidado** e a **saúde integral** através de práticas educativas e apoio profissional. Nossas ações visam construir uma cultura de paz e fortalecer a saúde em todos os seus aspectos:
                    </p>
                    
                    <ul class="list-style1 mb-4">
                        <li>Difusão de práticas educativas para **prevenção** em saúde mental e física, incentivando o **autocuidado**.</li>
                        <li>Promoção de **atendimento clínico psicológico**, atividades esportivas e laborais para a melhoria da qualidade de vida.</li>
                        <li>Fomento à **Comunicação Não Violenta (CNV)** para relações de confiança, cooperação e construção de uma cultura de paz.</li>
                    </ul>
                    
                    <h3 class="mb-1-6">PROJETO DE DESTAQUE: LUMINAR</h3>
                    <p>
                        **FINALIDADE:** Transformar a vida de **mulheres de 16 a 50 anos** com foco em saúde e bem-estar. O projeto oferece **atividades físicas** (como danças em grupo, fortalecimento e mobilidade) e **grupos de apoio** acompanhados por profissionais qualificados. O Luminar cria um ambiente de troca, motivação e solidariedade, resultando na melhoria da saúde física e mental das participantes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>