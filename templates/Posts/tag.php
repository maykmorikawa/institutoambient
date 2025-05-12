<!-- PAGE TITLE ================================================== -->
<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Blog Details</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="home">Home</a></li>
                        <li><a href="#!">Blog Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BLOG DETAILS ================================================== -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="row">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="col-lg-12 mb-2-3">
                                <div class="card card-style7 border-0">
                                    <?php if (!empty($post->image)): ?>
                                        <img src="<?= $this->Url->build('/img/' . $post->image) ?>" class="card-img-top" alt="<?= h($post->title) ?>">
                                    <?php endif; ?>
                                    <div class="card-body px-4 py-2-3">
                                        <h2 class="mb-4"><?= h($post->title) ?></h2>
                                        
                                        <p class="text-muted">
                                            Publicado em: 
                                            <?= $post->published ? $post->published->format('d/m/Y H:i') : 'Data não disponível' ?>
                                        </p>

                                        <div>
                                            <?= $this->Text->autoParagraph(h($post->content)) ?>
                                        </div>
                                        <!-- ... conteúdo do post ... -->
                                        <div class="mt-4">
                                            <strong>Tags:</strong>
                                            <?php if (!empty($post->tags)): ?>
                                                <?php foreach ($post->tags as $tag): ?>
                                                    <span class="badge bg-secondary"><?= h($tag->name) ?></span>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Nenhuma tag relacionada.</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- Autor -->
                                <div class="d-flex justify-content-center align-items-center mx-auto py-1-9 px-3 bg-light">
                                    <div class="me-3">
                                        <img class="rounded-circle w-60px" src="<?= $this->Url->build('/site/img/avatar/avatar-01.jpg') ?>" alt="...">
                                    </div>
                                    <div class="text-start">
                                        <h4 class="h6 mb-0">Postado por <?= h($post->author_name ?? 'Equipe Editorial') ?></h4>
                                        <span class="small text-muted"><?= $post->published ? $post->published->format('d M Y') : 'Data não disponível' ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma postagem encontrada para essa tag.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4">
                <div class="sidebar ps-xl-4">
                    <!-- Recentes -->
                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="400ms">
                        <h3 class="mb-1-6 h5">Postagens Recentes</h3>
                        <?php foreach ($recentes as $r): ?>
                            <div class="media mb-4">
                                <img src="<?= $r->imagem ?? $this->Url->image('/img/' . $r->image) ?>"
                                     class="rounded img-fluid"
                                     alt="<?= h($r->title) ?>"
                                     width="80" height="80"
                                     style="object-fit: cover;">
                                <div class="media-body ms-3">
                                    <h4 class="h6">
                                        <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $r->slug]) ?>">
                                            <?= h($r->title) ?>
                                        </a>
                                    </h4>
                                    <span class="small text-muted"><?= $r->published ? $r->published->format('d M Y') : 'Data não disponível' ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Tags -->
                    <?php if (!empty($tags)): ?>
                        <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="800ms">
                            <h3 class="mb-1-6 h5">Tags</h3>
                            <div class="tags">
                                <?php foreach ($tags as $tag): ?>
                                    <a href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'tag', $tag->slug]) ?>">
                                        <?= h($tag->name) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
