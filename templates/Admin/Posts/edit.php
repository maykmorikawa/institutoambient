<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= $post->isNew() ? __('Add Post') : __('Edit Post') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($post, ['enctype' => 'multipart/form-data']) ?>

                <div class="mb-3">
                    <?= $this->Form->control('title', ['class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('content', ['id' => 'summernote', 'class' => 'form-control', 'type' => 'textarea']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('category_id', [
                        'class' => 'form-control',
                        'label' => 'Categorias',
                        'options' => $categoryTree,
                        'empty' => 'Selecione a Categoria'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('user_id', [
                        'options' => $users,
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('slug', ['class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('excerpt', ['class' => 'form-control', 'rows' => 3]) ?>
                </div>

                <?php if (!empty($post->post_images)): ?>
                    <div class="mb-3">
                        <label><strong>Imagens atuais</strong></label>
                        <div class="row">
                            <?php foreach ($post->post_images as $img): ?>
                                <div class="col-md-3 text-center mb-4 border p-2 rounded">
                                    <img src="<?= $this->Url->build('/img/uploads/' . $img->filename) ?>" class="img-thumbnail mb-2" style="max-width:100%;">

                                    <!-- Checkbox para excluir -->
                                    <div class="form-check mb-1">
                                        <input type="checkbox" class="form-check-input" name="delete_images[<?= $img->id ?>]" value="1" id="delete_<?= $img->id ?>">
                                        <label class="form-check-label" for="delete_<?= $img->id ?>">Excluir</label>
                                    </div>

                                    <!-- Radio para destaque -->
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="featured_image_id" value="<?= $img->id ?>" id="featured_<?= $img->id ?>"
                                            <?= $img->is_featured ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="featured_<?= $img->id ?>">Destaque</label>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>


                <div class="mb-3">
                    <?= $this->Form->control('images[]', [
                        'label' => 'Novas imagens',
                        'type' => 'file',
                        'multiple' => true,
                        'class' => 'form-control'
                    ]) ?>
                </div>



                <div class="mb-3">
                    <?= $this->Form->control('status', [
                        'label' => 'Status',
                        'options' => [
                            'rascunho' => 'Rascunho',
                            'publicado' => 'Publicado'
                        ],
                        'empty' => 'Selecione um status',
                        'class' => 'form-control'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('published', ['empty' => true, 'class' => 'form-control']) ?>
                </div>

                <div class="mb-3">
                    <?= $this->Form->control('tags._ids', [
                        'options' => $tags,
                        'class' => 'form-control',
                        'multiple' => true,
                        'label' => __('Tags Relacionadas')
                    ]) ?>
                </div>

                <div class="d-grid">
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<script>
    $ < script >
        $(document).ready(function () {
            $('#summernote').summernote();
        });
</script>
</script>