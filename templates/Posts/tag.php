<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Tags Conteúdo</h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="home">Home</a></li>
                        <li><a href="#!">Tags Conteúdo</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="row">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="col-lg-12 mb-2-3">
                                <div class="card card-style7 border-0">

                                    <?php $featuredImage = null;
                                    foreach (($post->post_images ?? []) as $img) {
                                        if ($img->is_featured) {
                                            $featuredImage = $img;
                                            break;
                                        }
                                    } ?>

                                    <?php $postUrl = $this->Url->build(['controller' => 'Posts', 'action' => 'view', $post->slug]); ?>

                                    <a href="<?= $postUrl ?>" class="text-decoration-none text-dark">
                                        <?php if ($featuredImage): ?>
                                            <img src="<?= $this->Url->build('/img/uploads/' . $featuredImage->filename) ?>"
                                                class="card-img-top" alt="<?= h($post->title) ?>">
                                        <?php else: ?>
                                            <img src="<?= $this->Url->build('/site/img/avatar/avatar-02.png') ?>"
                                                class="card-img-top" alt="Imagem padrão">
                                        <?php endif; ?>
                                    </a>
                                    <div class="card-body px-4 py-2-3">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhuma postagem encontrada para essa tag.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar ps-xl-4">

                    <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="400ms">
                        <h3 class="mb-1-6 h5">Postagens Recentes</h3>
                        <?php foreach ($recentes as $r): ?>
                            <?php
                            // Lógica para imagem destacada do post recente
                            $featuredRecent = null;
                            foreach (($r->post_images ?? []) as $img) {
                                if ($img->is_featured) {
                                    $featuredRecent = $img;
                                    break;
                                }
                            }

                            $imagePath = $featuredRecent
                                ? $this->Url->build('/img/uploads/' . $featuredRecent->filename)
                                : $this->Url->build('/site/img/blog/1.jpg');
                            ?>
                            <div class="media mb-4">
                                <img src="<?= $imagePath ?>" class="rounded img-fluid" alt="<?= h($r->title) ?>" width="80"
                                    height="80" style="object-fit: cover;">
                                <div class="media-body ms-3">
                                    <h4 class="h6">
                                        <a
                                            href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'view', $r->slug]) ?>">
                                            <?= h($r->title) ?>
                                        </a>
                                    </h4>
                                    <span
                                        class="small text-muted"><?= $r->published ? $r->published->format('d M Y') : 'Data não disponível' ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($tags)): ?>
                        <div class="widget mb-1-9 p-4 wow fadeIn" data-wow-delay="800ms">
                            <h3 class="mb-1-6 h5">Tags</h3>
                            <div class="tags">
                                <?php foreach ($tags as $tag): ?>
                                    <a
                                        href="<?= $this->Url->build(['controller' => 'Posts', 'action' => 'tag', $tag->slug]) ?>">
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