<!-- PAGE TITLE

        ================================================== -->

<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">

    <div class="container position-unset">

        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">

            <div class="row">

                <div class="col-md-12">

                    <h1>Galeria de vídeos</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Galeria de vídeos</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- VIDEO SECTION -->
<?php
// Busca dos vídeos
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();

// Função para limpar o ID do Youtube
function extrairIdYoutube($url)
{
    $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
    if (preg_match($pattern, $url, $matches)) {
        return $matches[1];
    }
    return null;
}
?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php foreach ($videos as $video): ?>
                    <div class="mb-5 position-relative elements-block">

                        <!-- Título do Vídeo -->
                        <div class="inner-title mb-2">
                            <h2 class="h5 mb-0" style="color: #2c3e50;">
                                <?= h($video->title) ?>
                            </h2>
                        </div>

                        <!-- CONTAINER COM A ALTURA ORIGINAL (300px) -->
                        <div class="height-300"
                            style="height: 300px; position: relative; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

                            <?php
                            $bgImage = $video->background_image ? '/img/uploads/' . $video->background_image : '/site/img/bg/bg-08.jpg';
                            $videoId = extrairIdYoutube($video->video_url);
                            $urlFinal = "https://www.youtube.com/embed/" . $videoId . "?rel=0";
                            ?>

                            <!-- Imagem de Fundo Ajustada -->
                            <div class="story-video h-100" style="background-image: url('<?= $bgImage ?>'); 
                                    background-size: cover; 
                                    background-position: center; 
                                    background-repeat: no-repeat;">

                                <!-- Máscara escura para dar destaque ao play -->
                                <div style="position: absolute; inset: 0; background: rgba(0,0,0,0.2);"></div>

                                <!-- Botão de Play Centralizado -->
                                <div class="position-absolute top-50 start-50 translate-middle" style="z-index: 10;">
                                    <a class="popup-youtube" href="<?= $urlFinal ?>">
                                        <img src="/site/img/icons/play-icon.png" alt="Play"
                                            style="width: 70px; transition: transform 0.3s;"
                                            onmouseover="this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                        <!-- Caso não tenha a imagem do ícone, use o ícone abaixo: -->
                                        <!-- <i class="fa fa-play-circle" style="font-size: 70px; color: #fff;"></i> -->
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<!-- Mantenha os scripts do Magnific Popup que configuramos antes -->