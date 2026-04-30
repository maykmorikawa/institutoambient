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
// Busca os vídeos no banco de dados usando o CakePHP
$videosTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Videos');
$videos = $videosTable->find()->orderBy(['created' => 'DESC'])->all();
?>

<!-- Link para o CSS do Magnific Popup (Essencial para o vídeo aparecer no meio da tela) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">

                <?php foreach ($videos as $video): ?>
                    <div class="mb-6 mb-lg-8 position-relative elements-block">
                        <div class="inner-title">
                            <h2 class="mb-3"><?= h($video->title) ?></h2>
                        </div>

                        <!-- Definimos uma altura fixa para o container do vídeo aparecer -->
                        <div style="height: 400px; position: relative;">
                            <?php
                            $bgImage = $video->background_image ? '/img/uploads/' . $video->background_image : '/site/img/bg/bg-08.jpg';
                            $url = $video->video_url;

                            if ($url && !preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                $url = "https://" . $url;
                            }
                            ?>

                            <!-- A div abaixo usa o data-background. Certifique-se que seu CSS lê esse atributo ou use style inline -->
                            <div class="story-video bg-img cover-background h-100"
                                style="background-image: url('<?= $bgImage ?>'); background-size: cover; background-position: center;">

                                <div class="opacity-extra-medium bg-black"
                                    style="background: rgba(0,0,0,0.4); height: 100%;"></div>

                                <div class="text-center position-absolute top-50 start-50 translate-middle z-index-1">
                                    <!-- O link agora tem a classe 'popup-video' para o script encontrar -->
                                    <a class="video_btn popup-video" href="<?= h($url) ?>"
                                        style="font-size: 50px; color: #fff;">
                                        <i class="fa fa-play-circle"></i>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).ready(function () {
        // Inicializa o popup diretamente no link do vídeo
        $('.popup-video').magnificPopup({
            type: 'iframe',
            mainClass: 'mfp-fade',
            removalDelay: 160,
            preloader: false,
            fixedContentPos: false
        });
    });
</script>