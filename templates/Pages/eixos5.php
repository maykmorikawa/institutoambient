
<?php
// Carrossel superior
$carouselSuperior = [
    'intersetorial.png',
    'foto_4.jpg',
    'foto_5.jpg',
   
    
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

                    <h1>Eixo 05</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Eixo 05</a></li>

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
                    <div class="box-left py-2 px-4 px-sm-4 px-md-5">
                        <h3 class="text-secondary">+<span class="countup">10</span></h3>
                        <p class="lead mb-0 fw-bold text-dark">Ações Socioambientais</p>
                    </div>
                    <span class="about-img d-none d-lg-inline-block">
                        <img src="<?= WWW; ?>/site/img/content/dots1.png" alt="..."
                            class="position-absolute left-n25 bottom-n20 z-index-minus2 ani-left-right">
                    </span>
                </div>
            </div>
            
            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="about-title">
                    <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Conhecimento, Natureza e Inovação</span>
                    <h2 class="mb-1-6">EIXO 05: EDUCAÇÃO AMBIENTAL E GERAÇÃO DE RENDA SUSTENTÁVEL</h2>
                    <p class="fst-italic font-weight-600">
                        **OBJETIVO ESTRATÉGICO:** Difundir conhecimentos e habilidades socioambientais para a construção de estratégias sustentáveis para o desenvolvimento territorial, fortalecendo as diversas territorialidades locais.
                    </p>
                    
                    <p>
                        Este Eixo trabalha na intersecção entre a **preservação ambiental** e a **economia local**. Nossas ações são articuladas e participativas, garantindo que o conhecimento socioambiental se traduza em oportunidades reais de renda:
                    </p>
                    
                    <ul class="list-style1 mb-4">
                        <li>Realização de **vivências e campanhas** para difusão de conhecimentos socioambientais.</li>
                        <li>Desenvolvimento de **materiais educativos** (cartilhas, jogos, vídeos) sobre biodiversidade e crise climática para escolas parceiras.</li>
                        <li>**Capacitação** de comunidades em habilidades baseadas na natureza para fomentar empreendimentos de **renda sustentável**.</li>
                    </ul>
                    
                    <h3 class="mb-1-6">PROJETO DE DESTAQUE: TECENDO NOVOS RUMOS SUSTENTÁVEIS</h3>
                    <p>
                        **FINALIDADE:** Promover a **Inclusão Produtiva sustentável** de adolescentes de famílias vulneráveis em Belém/PA. O projeto efetiva o desenvolvimento de competências e habilidades baseadas na **natureza e no trabalho tecnológico**, contribuindo diretamente para a **geração de renda sustentável** e para a inovação como ferramenta de superação de desafios na adolescência.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>