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
// Busca dos vídeos no banco de dados (CakePHP)
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();

/**
 * MÉTODO EDUCATIVO: Função para extrair o ID do vídeo.
 * Não importa se o link é longo, curto ou com parâmetros extras,
 * ela retorna apenas o código de 11 dígitos.
 */
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
                    <div class="mb-5 position-relative">
                        <h2 class="h4 mb-3">
                            <?= h($video->title) ?>
                        </h2>

                        <div
                            style="height: 450px; position: relative; background-color: #000; border-radius: 12px; overflow: hidden;">
                            <?php
                            $bgImage = $video->background_image ? '/img/uploads/' . $video->background_image : '/site/img/bg/bg-08.jpg';

                            // Extraímos o ID (ex: TpS6aNGI4xs)
                            $videoId = extrairIdYoutube($video->video_url);

                            // Montamos a URL de embed perfeita
                            $urlFinal = "https://www.youtube.com/embed/" . $videoId . "?rel=0&amp;showinfo=0";
                            ?>

                            <!-- Imagem de Capa -->
                            <div class="h-100"
                                style="background: url('<?= $bgImage ?>') center/cover no-repeat; opacity: 0.8;"></div>

                            <!-- Botão Play -->
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <!-- A classe 'popup-youtube' ativa o script abaixo -->
                                <a class="popup-youtube" href="<?= $urlFinal ?>"
                                    style="cursor: pointer; text-decoration: none;">
                                    <i class="fa fa-play-circle"
                                        style="font-size: 80px; color: #fff; text-shadow: 0px 4px 15px rgba(0,0,0,0.5);"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<!-- SCRIPTS DE SUPORTE -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).ready(function () {
        $('.popup-youtube').magnificPopup({
            type: 'iframe',
            iframe: {
                markup: '<div class="mfp-iframe-scaler">' +
                    '<div class="mfp-close"></div>' +
                    '<iframe class="mfp-iframe" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' +
                    '</div>',
                patterns: {
                    youtube: {
                        index: 'youtube.com/',
                        id: null, // Deixamos nulo pois já tratamos a URL no PHP
                        src: '%id%'
                    }
                }
            }
        });
    });
</script>