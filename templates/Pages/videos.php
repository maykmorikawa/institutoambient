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
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();

/**
 * Função simples para converter URLs do YouTube para o formato embed
 * Exemplo: youtube.com/watch?v=123 -> youtube.com/embed/123
 */
function formatVideoUrl($url)
{
    if (strpos($url, 'youtube.com/watch?v=') !== false) {
        return str_replace('watch?v=', 'embed/', $url);
    }
    if (strpos($url, 'youtu.be/') !== false) {
        $id = substr(parse_url($url, PHP_URL_PATH), 1);
        return "https://www.youtube.com/embed/" . $id;
    }
    return $url;
}
?>

<section>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php foreach ($videos as $video): ?>
                    <div class="mb-6 mb-lg-8 position-relative elements-block">
                        <div class="inner-title">
                            <h2 class="mb-0">
                                <?= h($video->title) ?>
                            </h2>
                        </div>
                        <div class="height-300">
                            <?php
                            $bgImage = $video->background_image ? '/img/uploads/' . $video->background_image : '/site/img/bg/bg-08.jpg';

                            // 1. Pegamos a URL original
                            $originalUrl = $video->video_url;

                            // 2. Garantimos o protocolo https
                            if ($originalUrl && !preg_match("~^(?:f|ht)tps?://~i", $originalUrl)) {
                                $originalUrl = "https://" . $originalUrl;
                            }

                            // 3. Convertemos para o formato que o YouTube aceita em IFRAMES
                            $finalUrl = formatVideoUrl($originalUrl);
                            ?>

                            <div class="story-video bg-img cover-background h-100" data-overlay-dark="0"
                                style="background-image: url('<?= $bgImage ?>');">
                                <div class="opacity-extra-medium bg-black"></div>
                                <div class="inner-border"></div>
                                <div class="text-center position-absolute top-50 start-50 translate-middle z-index-1">
                                    <!-- Usamos a URL convertida aqui -->
                                    <a class="video video_btn" href="<?= h($finalUrl) ?>">
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
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<!-- Script corrigido para forçar o tipo iframe -->
<script>
    $(document).ready(function () {
        $('.story-video').magnificPopup({
            delegate: '.video',
            type: 'iframe',
            iframe: {
                patterns: {
                    youtube: {
                        index: 'youtube.com/',
                        id: 'embed/',
                        src: '%id%'
                    }
                }
            }
        });
    });
</script>