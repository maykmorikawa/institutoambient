<!-- PAGE TITLE -->
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Publicações</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="<?= $this->Url->build('/') ?>">Home</a></li>
                        <li><a href="#">Publicações do Site</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BLOG GRID -->
<section>
    <div class="container">
        <div class="text-center mb-2-9 mb-lg-6 wow fadeIn" data-wow-delay="100ms">
            <span class="text-secondary mb-2 d-block fw-bold text-uppercase">Instituto Ambient</span>
            <h2 class="mb-0 h1">Todas as Postagens</h2>
        </div>
        <div class="row mt-n1-9">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4 mt-1-9">
                        <article class="card card-style3 border-0 h-100">6
                            <div class="card-img position-relative">
                                <?php $featuredImage = null;
                                foreach ($post->post_images as $img) {
                                    if ($img->is_featured) {
                                        $featuredImage = $img;
                                        break;
                                    }
                                } ?>
                                <?php if ($featuredImage): ?>
                                    <img src="<?= $this->Url->build('/img/uploads/' . $featuredImage->filename) ?>"
                                        alt="<?= h($post->title) ?>">
                                <?php else: ?>
                                    <img src="<?= $this->Url->build('/site/img/avatar/avatar-02.png') ?>" alt="Imagem padrão">
                                <?php endif; ?>
                            </div>
                            <div class="card-body p-xl-1-9 p-4">
                                <h3 class="h5 mb-3">
                                    <a
                                        href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $post->slug]) ?>">
                                        <?= h($post->title) ?>
                                    </a>
                                </h3>
                                <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $post->slug]) ?>"
                                    class="fw-bold text-primary text-secondary-hover">Leia mais</a>
                            </div>
                            <div class="card-footer bg-white py-4 px-0 mx-4 mx-xl-1-9">
                                <div class="d-flex justify-content-between">
                                    <span class="display-30">
                                        <i class="ti-calendar me-1 text-primary"></i>
                                        <?= $post->published ? $post->published->format('d M Y') : 'Sem data' ?>
                                    </span>
                                    <span class="display-30">
                                        <i class="ti-user me-1 text-primary"></i>
                                        <?= h($post->user->name ?? 'Equipe') ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Nenhuma postagem encontrada.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Paginação -->
        <?php if (!empty($posts) && $this->Paginator->hasPage(2)):
            $this->Paginator->setTemplates([
                'nextActive' => '<li class="page-item"><a class="page-link" rel="next" href="{{url}}">{{text}}</a></li>',
                'nextDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
                'prevActive' => '<li class="page-item"><a class="page-link" rel="prev" href="{{url}}">{{text}}</a></li>',
                'prevDisabled' => '<li class="page-item disabled"><span class="page-link">{{text}}</span></li>',
                'number' => '<li class="page-item"><a class="page-link" href="{{url}}">{{text}}</a></li>',
                'current' => '<li class="page-item active" style="z-index: 1;"><span class="page-link bg-primary border-primary text-white">{{text}}</span></li>',
            ]);
            ?>
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navegação de página">
                        <ul class="pagination justify-content-center">
                            <?= $this->Paginator->prev('<i class="fas fa-chevron-left me-1"></i> Anterior', ['escape' => false, 'class' => 'page-link rounded-start']) ?>
                            <?= $this->Paginator->numbers(['modulus' => 4]) ?>
                            <?= $this->Paginator->next('Próxima <i class="fas fa-chevron-right ms-1"></i>', ['escape' => false, 'class' => 'page-link rounded-end']) ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <style>
                .page-item.active .page-link {
                    z-index: 3 !important;
                }

                .page-link {
                    color: #51b54a;
                }

                .page-link:hover {
                    color: #fff;
                    background-color: #51b54a;
                    border-color: #51b54a;
                }

                .pagination {
                    flex-wrap: wrap;
                }
            </style>
        <?php endif; ?>

    </div>
</section>