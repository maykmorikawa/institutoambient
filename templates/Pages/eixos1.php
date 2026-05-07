<?php
// Carrossel superior
$carouselSuperior = [
    'foto_6.jpg',
    'foto_7.jpg',
    'foto_11.jpg',
    'ct_bale.jpg',
    'ct_infor.jpg',
    
];

// Carrossel inferior
$carouselInferior = [
    'foto_12.jpg',
    'foto_08.jpg',
    'foto_09.jpg',
    'ct_musica.jpg',
    'ct_sport.jpg',

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

                    <h1>Eixo 01</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Eixo 01</a></li>

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

                    <div class="box-left py-2 px-4 px-sm-4 px-md-5" style="margin-bottom: -150px; left: -9px;">
                        <h3 class="text-secondary"><span class="countup">06</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Projetos Ativos</p>
                    </div>

                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>

            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Nossas Ações de Proteção Social</span>
                    <h2 class="mb-1-6">EIXO 01: POTENCIALIZAÇÃO DA CAPACIDADE PROTETIVA DAS FAMÍLIAS</h2>
                    <p class="fst-italic font-weight-600">
                        FINALIDADES
                    </p>                    
                    <ul class="list-style1 mb-4">
                        <li>Promover o trabalho social proativo com famílias vulneráveis, articulando o acesso a redes de proteção e serviços sociais para assegurar seus direitos fundamentais.</li>
                        <li>Oportunizar espaços socioeducativos e intergeracionais de convivência e lazer, fortalecendo vínculos e o protagonismo para prevenir violências e promover a cidadania.</li>
                        <li>Viabilizar o acompanhamento social proativo de idosos e pessoas com deficiência, fomentando a convivência comunitária para prevenir o isolamento e o rompimento de vínculos.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="aboutus bg-light">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Resultados na Comunidade</span>
                    <h2 class="mb-1-6">PROJETOS DO INSTITUTO AMBIENT NO EIXO 01</h2>

                    <ul class="list-style2 mb-4">
                        <li>Serviço de Convivência e FortalecimentodeVínculos (SCFV)</li>
                        <li>VOZES DAS ÁGUAS: Arte e Educação nos territórios ribeirinhos de Belém/Pará.</li>
                        <li>FLORES DO OÁSIS: Artesanato sustentável e geração de renda.</li>
                        <li>OÁSIS: Envelhecimento ativo e inclusão de mulheres 50+.</li>
                        <li>CRESCER E TRANSFORMAR: Construindo um Futuro Digital</li>
                        <li>PROJETO AURORA: Apoio a Mulheres Grávidas Vulneráveis nos Municípios de Belém e Jacundá.</li>
                    </ul>
                </div>
            </div>            
            <div class="col-lg-6 mb-2-2 mb-lg-0 wow fadeIn" data-wow-delay="200ms">
                <div class="pe-lg-1-9 pe-xl-2-9 position-relative z-index-1">

                    <div id="carouselInferior" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-indicators">
                            <?php foreach ($carouselInferior as $i => $img): ?>
                                <button type="button"
                                        data-bs-target="#carouselInferior"
                                        data-bs-slide-to="<?= $i ?>"
                                        class="<?= $i === 0 ? 'active' : '' ?>"
                                        aria-label="Slide <?= $i + 1 ?>"></button>
                            <?php endforeach; ?>
                        </div>

                        <div class="carousel-inner">
                            <?php foreach ($carouselInferior as $i => $img): ?>
                                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                                    <img src="<?= WWW; ?>/site/img/about/<?= $img ?>" class="d-block w-100 rounded">
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselInferior" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselInferior" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>

                    <div class="box-left py-2 px-4 px-sm-4 px-md-5" style="margin-bottom: -150px; left: -9px;">
                        <h3 class="text-secondary"><span class="countup">72</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Famílias Alcançadas</p>
                    </div>

                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>