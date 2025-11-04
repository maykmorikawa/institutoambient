<style>
    /* Reset básico para remover margens e preenchimentos padrão do navegador */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        /* CORREÇÃO: Removemos 'height: 100%' */
        overflow-y: scroll; 
        overflow-x: hidden; /* Previne rolagem horizontal indesejada */
    }

    /* 1. O Container Principal: Configura o palco */
    .full-screen-container {
        width: 100vw;
        display: flex;
        flex-direction: column; /* Empilha os slides verticalmente */
    }

    /* 2. O Slide Individual: Garante que cada um seja tela cheia */
    .slide {
        width: 100vw; /* 100% da largura da viewport */
        height: 100vh; /* 100% da altura da viewport - Mantém o efeito full-screen */
        /* Garante que o conteúdo dentro do slide (a imagem) ocupe o espaço */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* 3. A Imagem: Garante que ela preencha o slide sem distorcer (mantendo a proporção) */
    .slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">

    <div class="container position-unset" style="margin-bottom: 55px;">

        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">

            <div class="row">

                <div class="col-md-12">

                    <h1>Captação de recursos</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Captação de recursos</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>

<section class="pt-0 my-5">

    <div class="full-screen-container">
        
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/1Prancheta.webp" alt="Nossa Missão: Impacto Social e Sustentável - Instituto Ambient">
            </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/2Prancheta.webp" alt="Projeto Trabalho Lado a Lado - Juntos pela transformação social">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/3Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/4Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/5Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/7Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/8Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/9Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/10Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/11Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/12Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/13Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/14Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/15Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/16Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/17Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/18Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/19Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/20Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/21Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
        <div class="slide">
            <img src="<?= WWW; ?>/slides/img/1x/webp/22Prancheta.webp" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
        </div>
    </div>

</section>