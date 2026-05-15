<?php
// Carrossel superior
$carouselSuperior = [
    'foto_10.jpg',
    'ldald_1.jpg',
    'ldald_2.jpg',
   
];

// Carrossel inferior
$carouselInferior = [
    'maria.jpg',
    'tdc.jpg',
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

                    <h1>Eixo 02</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="<?= $this->Url->build('/') ?>">Home</a></li>

                        <li><a href="#!">Eixo 02</a></li>

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
                        <h3 class="text-secondary">+<span class="countup">5</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Projetos de Empreendedorismo</p>
                    </div>

                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>

            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Inclusão, Tecnologia e Bioeconomia</span>
                    <h2 class="mb-1-6">EIXO 02: PROPORCIONANDO GERAÇÃO DE EMPREGO E RENDA</h2>
                    <p class="fst-italic font-weight-600">
                        FINALIDADE
                    </p>                    
                    <ul class="list-style1 mb-4">
                        <li>Garantir qualificação e formação em temáticas a respeito de direitos, cidadania e arco ocupacional, para acesso ao mundo do trabalho.</li>
                        <li>Promover ações na área da bioeconomia, com finalidade de criar produtos e serviços mais sustentáveis.</li>
                        <li>Efetivar Tecnologias Digitais, de Informação e da Comunicação, letramento digital e pensamento Computacional, na perspectiva de ampliação do ensino e aprendizagem relacionando a tecnologia e inovação.</li>
                        <li>Executar ações e serviços de tecnologias sociais, para garantia de sustentabilidade local.</li>
                        <li>Capacitar comunidades em habilidades baseadas na natureza para a criação de empreendimentos individuais ou coletivos que gerem renda sustentável.</li>
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
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Iniciativas de Destaque</span>
                    <h2 class="mb-1-6">PROJETOS DO INSTITUTO AMBIENT NO EIXO 02</h2>

                    <ul class="list-style2 mb-4">
                        <li>Amazônia em Palavras: Aventuras Literárias com Crianças e Jovens</li>
                        <li>TECENDO NOVOS RUMOS SUSTENTÁVEIS: Inclusão Produtiva sustentável de adolescentes.</li>
                        <li>ESCREVENDO E REESCREVENDO NOSSA HISTÓRIA (PERNOH)</li>
                        <li>Mariá: Construindo Negócios Femininos Sustentáveis</li>
                        <li>LADO A LADO</li>
                        <li>TALENTOS DA COZINHA AMAZÔNICA.</li>
                        <li>MODELAGEM DE NEGÓCIOS.</li>
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
                        <h3 class="text-secondary">+<span class="countup">240</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Capacitados para o Mercado</p>
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