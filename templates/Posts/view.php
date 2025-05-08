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
                    <div class="col-lg-12 mb-2-3">
                        <div class="card card-style7 border-0">
                            <?php if (!empty($post->image)): ?>
                                <img src="<?= $this->Url->build('/img/' . $post->image) ?>" class="card-img-top" alt="<?= h($post->title) ?>">
                            <?php endif; ?>
                            <div class="card-body px-4 py-2-3">
                                <h2 class="mb-4"><?= h($post->title) ?></h2>
                                <p class="text-muted">Publicado em: <?= $post->created->format('d/m/Y H:i') ?></p>

                                <div>
                                    <?= $this->Text->autoParagraph(h($post->content)) ?>
                                </div>

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

                                <div class="pt-4">
                                    <h4 class="h6 d-inline-block me-2">Compartilhar:</h4>
                                    <a href="#!" class="me-2"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#!" class="me-2"><i class="fab fa-twitter"></i></a>
                                    <a href="#!" class="me-2"><i class="fab fa-instagram"></i></a>
                                    <a href="#!" class="me-2"><i class="fab fa-youtube"></i></a>
                                    <a href="#!"><i class="fab fa-linkedin-in"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Autor do post ou avatar fictício -->
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-center align-items-center mx-auto py-1-9 px-3 bg-light">
                            <div class="me-3"><img class="rounded-circle w-60px" src="/<?= WWW; ?>/site/img/avatar/avatar-01.jpg" alt="..."></div>
                            <div class="text-start">
                                <h4 class="h6 mb-0">Postado por <?= h($post->author_name ?? 'Equipe Editorial') ?></h4>
                                <span class="small text-muted"><?= $post->created->format('d M Y') ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Comentários e formulário de resposta estáticos (pode ser dinâmico depois) -->
                    <!-- ... mantenha os comentários como no seu template original aqui, se desejar ... -->
                </div>

            </div>
            <div class="col-lg-4">
                <div class="sidebar ps-xl-4">
                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="200ms">
                        <div class="input-group">
                            <input type="text" class="form-control search-input" placeholder="Search here...">
                            <div class="input-group-append">
                                <button class="butn-style3" type="button"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="400ms">
                        <h3 class="mb-1-6 h5">Postagens Recentes</h3>

                        <?php foreach ($recentes as $r): ?>
                            <div class="media mb-4">
                                <img src="<?= $r->imagem ?? $this->Url->image('/img/' . $r->image) ?>"
                                    class="rounded img-fluid"
                                    alt="<?= h($r->title) ?>"
                                    width="160" height="160"
                                    style="object-fit: cover;">

                                <div class="media-body ms-3">
                                    <h4 class="h6">
                                        <a href="<?= $this->Url->build([h($r->slug)]) ?>">
                                            <?= h($r->title) ?>
                                        </a>

                                    </h4>
                                    <p class="mb-0 small"><?= $r->created->format('M d, Y') ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="600ms">
                        <h3 class="mb-1-6 h5">Categories</h3>
                        <ul class="list-style5 mb-0 ps-0">
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Business (6)</a></li>
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Development (4)</a></li>
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Technology (3)</a></li>
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Web (2)</a></li>
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Business (5)</a></li>
                            <li><a href="#!"><i class="ti-angle-right text-primary me-2 display-32"></i>Corporate (2)</a></li>
                        </ul>
                    </div>
                    <?php if (!empty($post->tags)): ?>
                        <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="800ms">
                            <h3 class="mb-1-6 h5">Tags</h3>
                            <div class="tags">
                                <?php foreach ($post->tags as $tag): ?>
                                <a href="<?= $this->Url->build([
                                    'controller' => 'Posts',
                                    'action' => 'tag',
                                    $tag->slug
                                    ]) ?>">
                                    <?= h($tag->name) ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="widget p-4 wow fadeIn" data-wow-delay="1000ms">
                        <h3 class="mb-1-6 h5">Follow Us</h3>
                        <div>
                            <a href="#!" class="me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#!" class="me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#!" class="me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#!" class="me-2"><i class="fab fa-youtube"></i></a>
                            <a href="#!"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>