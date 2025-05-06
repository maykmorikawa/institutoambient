<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <h1><?= h($post->title) ?></h1>
            <p class="text-muted">Publicado em: <?= $post->created->format('d/m/Y H:i') ?></p>

            <?php if (!empty($post->image)): ?>
                <img src="<?= $this->Url->build('/img/uploads/' . $post->image) ?>" alt="<?= h($post->title) ?>" class="img-fluid mb-3">
            <?php endif; ?>

            <div>
                <?= $this->Text->autoParagraph(h($post->content)); ?>
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
        </div>
    </div>
</div>