<!-- PAGE TITLE -->
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Blogs</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="<?= $this->Url->build('/') ?>">Home</a></li>
                        <li><a href="#">Blogs</a></li>
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
            <h2 class="mb-0 h1">Lista de Novidades &amp; Notícias</h2>
        </div>
        <div class="row mt-n1-9">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 col-lg-4 mt-1-9">
                        <article class="card card-style3 border-0 h-100">
                            <div class="card-img position-relative">
                                <img src="<?= $this->Url->build('/img/' . $post->image) ?>" alt="<?= h($post->title) ?>">
                            </div>
                            <div class="card-body p-xl-1-9 p-4">
                                <h3 class="h5 mb-3">
                                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $post->slug]) ?>">
                                        <?= h($post->title) ?>
                                    </a>
                                </h3>
                                <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $post->slug]) ?>" class="fw-bold text-primary text-secondary-hover">Leia mais</a>
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
    </div>
</section>
