<!-- PAGE TITLE ================================================== -->
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
                        <li><a href="<?= $this->Url->build('/') ?>">Home</a></li>
                        <li><a href="#!">Galeria de vídeos</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- VIDEO SECTION ================================================== -->
<?php
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();

/**
 * Função simplificada para extrair o ID do vídeo e gerar o link Embed mais compatível
 */
function getYouTubeEmbedUrl($url)
{
    $videoId = '';
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $matches)) {
        $videoId = $matches[1];
    }

    if (!empty($videoId)) {
        // Usamos youtube-nocookie para evitar bloqueios e garantir maior compatibilidade
        return "https://www.youtube-nocookie.com/embed/" . $videoId . "?rel=0&autoplay=1";
    }
    return $url;
}
?>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php foreach ($videos as $video): ?>
                    <!-- Bloco Vídeo -->
                    <div class="mb-6 mb-lg-8 position-relative elements-block">
                        <div class="inner-title mb-3">
                            <h2 class="mb-0"><?= h($video->title) ?></h2>
                        </div>

                        <div class="height-300" style="height: 300px; position: relative; overflow: hidden; border-radius: 10px;">
                            <?php
                            $bgImage = $video->background_image ? '/img/uploads/' . $video->background_image : '/site/img/bg/bg-08.jpg';
                            $urlEmbed = getYouTubeEmbedUrl($video->video_url);
                            ?>

                            <div class="story-video bg-img cover-background h-100" data-overlay-dark="0"
                                data-background="<?= $bgImage ?>"
                                style="background-image: url('<?= $bgImage ?>'); background-size: cover; background-position: center;">

                                <div class="opacity-extra-medium bg-black"></div>
                                <div class="inner-border"></div>

                                <div class="text-center position-absolute top-50 start-50 translate-middle z-index-1">
                                    <a class="video video_btn" href="<?= h($urlEmbed) ?>">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if ($videos->count() === 0): ?>
                    <div class="text-center py-5">
                        <h3>Nenhum vídeo disponível no momento.</h3>
                        <p>Em breve traremos novidades para você!</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<!-- Scripts para garantir que o player funcione -->
<script src="/site/js/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        if ($.fn.magnificPopup) {
            $('.story-video').magnificPopup({
                delegate: '.video',
                type: 'iframe',
                iframe: {
                    markup: '<div class="mfp-iframe-scaler">' +
                        '<div class="mfp-close"></div>' +
                        '<iframe class="mfp-iframe" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' +
                        '</div>',
                    patterns: {
                        youtube: {
                            index: 'youtube.com/',
                            id: 'v=',
                            src: 'https://www.youtube-nocookie.com/embed/%id%?autoplay=1&rel=0'
                        }
                    }
                }
            });
        }
    });
</script>