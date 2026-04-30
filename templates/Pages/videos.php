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
// 1. Busca os vídeos (Mantendo sua estrutura CakePHP)
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();

/**
 * MÉTODO EDUCATIVO: Esta função limpa o link do YouTube.
 * Ela aceita links do tipo: youtu.be/ID ou youtube.com/watch?v=ID
 */
function prepararLinkYoutube($url)
{
    // Remove espaços em branco
    $url = trim($url);

    // Se o link for do tipo youtu.be (como o da sua foto)
    if (strpos($url, 'youtu.be/') !== false) {
        $partes = explode('youtu.be/', $url);
        $idVideo = $partes[1];
        return "https://www.youtube.com/embed/" . $idVideo;
    }

    // Se o link for do tipo comum youtube.com/watch?v=...
    if (strpos($url, 'v=') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $vars);
        return "https://www.youtube.com/embed/" . $vars['v'];
    }

    return $url; // Retorna original se não identificar YouTube
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
                            // Chamada da nossa função educativa
                            $linkLimpo = prepararLinkYoutube($video->video_url);
                            ?>

                            <!-- Imagem de Capa -->
                            <div class="h-100"
                                style="background: url('<?= $bgImage ?>') center/cover no-repeat; opacity: 0.7;"></div>

                            <!-- Botão Play -->
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <a class="btn-popup-video" href="<?= h($linkLimpo) ?>" style="cursor: pointer;">
                                    <i class="fa fa-play-circle"
                                        style="font-size: 80px; color: #fff; text-shadow: 2px 2px 10px rgba(0,0,0,0.5);"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
</section>

<!-- Scripts Necessários -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).ready(function () {
        // Configuração do Magnific Popup para carregar o link como um IFRAME
        $('.btn-popup-video').magnificPopup({
            type: 'iframe',
            iframe: {
                markup: '<div class="mfp-iframe-scaler">' +
                    '<div class="mfp-close"></div>' +
                    '<iframe class="mfp-iframe" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' +
                    '</div>'
            }
        });
    });
</script>