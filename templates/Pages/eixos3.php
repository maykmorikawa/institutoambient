<?php
// Carrossel superior
$carouselSuperior = [
    'pda.jpg',
   
    
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

                    <h1>Eixo 03</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Eixo 03</a></li>

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
                        <h3 class="text-secondary"><span class="countup">23</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Organizações Apoiadas</p>
                    </div>
                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>
            
            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Fortalecimento da Sociedade Civil</span>
                    <h2 class="mb-1-6">EIXO 03: REDES E ASSESSORAMENTO INSTITUCIONAL</h2>
                    <p class="fst-italic font-weight-600">
                        **OBJETIVO ESTRATÉGICO:** Prestar serviços de assessoramento voltados ao fortalecimento das Organizações da Sociedade Civil, movimentos sociais e lideranças comunitárias, com atuação permanente em rede pela promoção e defesa dos direitos humanos.
                    </p>
                    
                    <p>
                        O Instituto Ambient atua como um catalisador, fornecendo o **suporte técnico e estratégico** necessário para que as organizações locais maximizem seu impacto e promovam o desenvolvimento sustentável de forma inclusiva.
                    </p>
                    
                    <h3 class="mb-1-6">AÇÕES E PROJETOS EM DESTAQUE</h3>
                    
                    <ul class="list-style1 mb-4">
                        <li>**Ações Estratégicas:** Apoiar o desenvolvimento institucional de **23 Organizações da Sociedade Civil (OSCs)** na Região Metropolitana de Belém, alcançando aproximadamente **230 pessoas**.</li>
                        <li>**Projeto Assessoramento OSCs (Parceria: Instituto ACP):** Iniciativa em andamento que mapeou as necessidades de 76 OSCs (via Google Forms) para oferecer **apoio personalizado** em gestão cadastral, documental, captação de recursos e certificações.</li>
                        <li>**Foco:** Superar desafios, promover a inovação e a integração para um desenvolvimento sustentável e inclusivo das comunidades.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>