<style>
  /* Reset básico para remover margens e preenchimentos padrão do navegador */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

html, body {
    /* Garante que o corpo e o html ocupem 100% da altura da viewport (tela) */
    height: 100%; 
    overflow: auto; /* Permite a rolagem para ver todos os slides */
}

/* 1. O Container Principal: Configura o palco */
.full-screen-container {
    /* Não é estritamente necessário um tamanho aqui, 
       pois os slides farão o contêiner crescer, 
       mas vamos definir 100% para consistência. */
    width: 100vw;
    min-height: 100vh; /* Garante que o contêiner tenha pelo menos a altura da tela */
    display: flex;
    flex-direction: column; /* Empilha os slides verticalmente */
}

/* 2. O Slide Individual: Garante que cada um seja tela cheia */
.slide {
    width: 100vw; /* 100% da largura da viewport */
    height: 100vh; /* 100% da altura da viewport */
    /* Garante que o conteúdo dentro do slide (a imagem) ocupe o espaço */
    display: flex;
    justify-content: center;
    align-items: center;
    /* Adicione mais estilos como padding se o conteúdo não for a imagem */
}

/* 3. A Imagem: Garante que ela preencha o slide sem distorcer (mantendo a proporção) */
.slide img {
    width: 100%; /* Ocupa 100% da largura do seu container (.slide) */
    height: 100%; /* Ocupa 100% da altura do seu container (.slide) */
    /* ESSENCIAL: Controla como a imagem se encaixa no container */
    object-fit: contain; /* Ajusta a imagem inteira dentro do contêiner, mostrando barras (preto) se a proporção não for idêntica. */
    /* Se quiser que a imagem preencha TODO o espaço, cortando o que não cabe, use: */
    /* object-fit: cover; */
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



<!-- PROJETOS ================================================== -->

<section class="pt-0 my-5">

  <div class="full-screen-container">
      
    <div class="slide">
        <img src="site/img/about/crescer_transformar.jpg" alt="Nossa Missão: Impacto Social e Sustentável - Instituto Ambient">
        </div>
    <div class="slide">
        <img src="site/img/about/trabalho_lado_a_lado.jpg" alt="Projeto Trabalho Lado a Lado - Juntos pela transformação social">
    </div>
    <div class="slide">
        <img src="image_8881c2.jpg" alt="O Cenário: Desafios e Oportunidades em Belém - Instituto Ambient">
    </div>
  </div>

</section>