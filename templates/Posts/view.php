<!-- PAGE TITLE
        ================================================== -->
        <section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Blog Details</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="#!">Blog Details</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BLOG DETAILS
        ================================================== -->
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
                            <div class="me-3"><img class="rounded-circle w-60px" src="/img/avatar/avatar-01.jpg" alt="..."></div>
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
                        <h3 class="mb-1-6 h5">Recent Posts</h3>
                        <div class="media mb-4">
                            <img src="img/blog/blog-thumb1.jpg" class="rounded" alt="...">
                            <div class="media-body ms-3">
                                <h4 class="h6"><a href="#!">Here's what people are saying about insurance.</a></h4>
                                <p class="mb-0 small">Mar 8, 2021</p>
                            </div>
                        </div>
                        <div class="media mb-4">
                            <img src="img/blog/blog-thumb2.jpg" class="rounded" alt="...">
                            <div class="media-body ms-3">
                                <h4 class="h6"><a href="#!">You will never believe these truth behind insurance.</a></h4>
                                <p class="mb-0 small">Mar 1, 2021</p>
                            </div>
                        </div>
                        <div class="media">
                            <img src="img/blog/blog-thumb3.jpg" class="rounded" alt="...">
                            <div class="media-body ms-3">
                                <h4 class="h6"><a href="#!">How to have fantastic insurance with minimal spending.</a></h4>
                                <p class="mb-0 small">Feb 25, 2021</p>
                            </div>
                        </div>
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
                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="800ms">
                        <h3 class="mb-1-6 h5">Tags</h3>
                        <div class="tags">
                            <a href="#!">agency</a>
                            <a href="#!">business</a>
                            <a href="#!">design</a>
                            <a href="#!">development</a>
                            <a href="#!">technology</a>
                            <a href="#!">web</a>
                            <a href="#!">corporate</a>
                            <a href="#!">startup</a>
                        </div>
                    </div>
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