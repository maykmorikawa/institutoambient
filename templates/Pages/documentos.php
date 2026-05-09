<!-- PAGE TITLE

        ================================================== -->

<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">

    <div class="container position-unset">

        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">

            <div class="row">

                <div class="col-md-12">

                    <h1>Documentos</h1>

                </div>

                <div class="col-md-12">

                    <ul class="ps-0">

                        <li><a href="home">Home</a></li>

                        <li><a href="#!">Documentos</a></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

</section>
<!-- LIST STYLES
        ================================================== -->
<section>
    <div class="container">
        <div class="row">
            <!-- Documentos do IA -->
            <div class="col-lg-6 mb-1-9 mb-lg-0 wow fadeIn" data-wow-delay="200ms">
                <div class="pe-lg-1-9 pe-xl-5">
                    <div class="inner-title mb-4">
                        <h2 class="h3 mb-0 text-secondary">Documentos do IA</h2>
                        <div class="title-border bg-primary mt-2"></div>
                    </div>
                    <ul class="list-style4 ps-0">
                        <?php if (!empty($docsIA) && !$docsIA->isEmpty()): ?>
                            <?php foreach ($docsIA as $doc): ?>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="ti-files text-danger me-3 h4 mb-0" style="font-family: 'themify' !important;"></i>
                                    <a href="<?= $this->Url->build('/uploads/pdfs/' . h($doc->filename)) ?>" target="_blank" class="text-dark fw-bold hover-primary">
                                        <?= h($doc->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="mb-3 p-3 text-muted border-0 bg-transparent">Nenhum documento disponível no momento.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Relatório IA -->
            <div class="col-lg-6 wow fadeIn" data-wow-delay="400ms">
                <div class="ps-lg-1-9 ps-xl-5">
                    <div class="inner-title mb-4">
                        <h2 class="h3 mb-0 text-secondary">Relatório IA</h2>
                        <div class="title-border bg-primary mt-2"></div>
                    </div>
                    <ul class="list-style4 ps-0">
                        <?php if (!empty($docsRelatorio) && !$docsRelatorio->isEmpty()): ?>
                            <?php foreach ($docsRelatorio as $doc): ?>
                                <li class="mb-3 d-flex align-items-center">
                                    <i class="ti-files text-danger me-3 h4 mb-0" style="font-family: 'themify' !important;"></i>
                                    <a href="<?= $this->Url->build('/uploads/pdfs/' . h($doc->filename)) ?>" target="_blank" class="text-dark fw-bold hover-primary">
                                        <?= h($doc->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="mb-3 p-3 text-muted border-0 bg-transparent">Nenhum relatório disponível no momento.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        .title-border {
            height: 3px;
            width: 50px;
        }
        .hover-primary:hover {
            color: #0026a2 !important;
            text-decoration: underline !important;
        }
        .list-style4 li {
            list-style: none;
            padding: 10px 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .list-style4 li:hover {
            background: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transform: translateX(5px);
        }
    </style>
</section>
