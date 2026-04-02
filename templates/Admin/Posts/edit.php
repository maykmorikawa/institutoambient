<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 * @var array $categoryTree
 * @var array $users
 * @var array $tags
 */
?>

<div class="posts edit content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Editar Post') ?></h1>
        <div class="btn-group shadow-sm">
            <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm mr-2 text-white-50"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="fas fa-eye fa-sm mr-2 text-white-50"></i> Ver no Site', ['prefix' => false, 'controller' => 'Posts', 'action' => 'view', $post->slug], ['class' => 'btn btn-sm btn-info', 'target' => '_blank', 'escape' => false]) ?>
        </div>
    </div>

    <?= $this->Form->create($post, ['enctype' => 'multipart/form-data', 'class' => 'user']) ?>
    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-primary">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Conteúdo Principal') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Título do Post') ?></label>
                        <?= $this->Form->control('title', [
                            'label' => false,
                            'class' => 'form-control form-control-lg border-left-primary shadow-sm',
                            'placeholder' => 'Digite o título aqui...'
                        ]) ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold small text-uppercase"><?= __('Corpo do Texto') ?></label>
                        <?= $this->Form->control('content', [
                            'label' => false,
                            'class' => 'form-control',
                            'id' => 'summernote',
                            'rows' => 15
                        ]) ?>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold small text-uppercase"><?= __('Resumo (Excerpt)') ?></label>
                        <?= $this->Form->control('excerpt', [
                            'label' => false,
                            'class' => 'form-control border-left-secondary',
                            'rows' => 3,
                            'placeholder' => 'Uma breve descrição para as listagens...'
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Gerenciamento de Imagens -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white collapse-inner rounded">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Mídia e Galeria') ?></h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($post->post_images)): ?>
                        <div class="row mb-4">
                            <?php foreach ($post->post_images as $img): ?>
                                <div class="col-md-4 col-sm-6 mb-4">
                                    <div class="card h-100 border-<?= $img->is_featured ? 'primary border-2 shadow' : 'light border-1' ?>">
                                        <div class="position-relative">
                                            <img src="<?= $this->Url->build('/img/uploads/' . $img->filename) ?>" 
                                                 class="card-img-top" style="height: 150px; object-fit: cover;" alt="Post Image">
                                            <?php if ($img->is_featured): ?>
                                                <span class="badge badge-primary position-absolute m-2 shadow-sm" style="top:0; left:0;"><i class="fas fa-star mr-1"></i>Destaque</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body p-2 bg-light border-top">
                                            <div class="custom-control custom-radio mb-2 p-2 bg-white rounded border shadow-xs px-4">
                                                <input type="radio" class="custom-control-input" name="featured_image_id" 
                                                       value="<?= $img->id ?>" id="featured_<?= $img->id ?>" <?= $img->is_featured ? 'checked' : '' ?>>
                                                <label class="custom-control-label small font-weight-bold" for="featured_<?= $img->id ?>">Destaque</label>
                                            </div>
                                            <div class="custom-control custom-checkbox p-2 bg-white rounded border shadow-xs px-4">
                                                <input type="checkbox" class="custom-control-input" name="delete_images[<?= $img->id ?>]" 
                                                       value="1" id="delete_<?= $img->id ?>">
                                                <label class="custom-control-label small text-danger font-weight-bold" for="delete_<?= $img->id ?>">Remover</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="upload-new p-4 border rounded bg-gray-100 border-dashed text-center">
                        <i class="fas fa-plus-circle fa-2x text-primary mb-2 opacity-50"></i>
                        <h6 class="font-weight-bold">Upload de Novas Imagens</h6>
                        <p class="small text-muted mb-3">Selecione uma ou mais imagens para adicionar à galeria.</p>
                        <?= $this->Form->control('images[]', [
                            'label' => false,
                            'type' => 'file',
                            'multiple' => true,
                            'class' => 'form-control-file d-inline-block mt-2',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral (Sidebar) -->
        <div class="col-lg-4">
            <!-- Card de Publicação -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paper-plane mr-2"></i><?= __('Publicação') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-uppercase"><?= __('Status Atual') ?></label>
                        <?= $this->Form->control('status', [
                            'label' => false,
                            'options' => [
                                'rascunho' => 'Rascunho',
                                'publicado' => 'Publicado'
                            ],
                            'class' => 'custom-select border-left-info font-weight-bold',
                        ]) ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="small font-weight-bold text-uppercase"><?= __('Agendar Publicação') ?></label>
                        <?= $this->Form->control('published', [
                            'label' => false,
                            'class' => 'form-control small shadow-sm',
                            'empty' => true
                        ]) ?>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-uppercase"><?= __('Autor do Post') ?></label>
                        <?= $this->Form->control('user_id', [
                            'label' => false,
                            'options' => $users,
                            'class' => 'custom-select border-left-secondary font-weight-bold',
                        ]) ?>
                    </div>
                </div>
                <div class="card-footer bg-white py-3 border-top-0">
                    <button type="submit" class="btn btn-primary btn-icon-split btn-block shadow font-weight-bold">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text w-100"><?= __('Atualizar Postagem') ?></span>
                    </button>
                    <?= $this->Html->link(__('Descartar Alterações'), ['action' => 'index'], ['class' => 'btn btn-link btn-block btn-sm text-secondary decoration-none']) ?>
                </div>
            </div>

            <!-- Card de Organização -->
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-folder mr-2"></i><?= __('Categorização') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-uppercase"><?= __('Categoria') ?></label>
                        <?= $this->Form->control('category_id', [
                            'label' => false,
                            'options' => $categoryTree,
                            'empty' => 'Selecione...',
                            'class' => 'custom-select border-left-warning'
                        ]) ?>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-uppercase"><?= __('URL Personalizada (Slug)') ?></label>
                        <?= $this->Form->control('slug', [
                            'label' => false,
                            'class' => 'form-control form-control-sm text-muted',
                        ]) ?>
                        <small class="form-text text-info mt-2"><i class="fas fa-info-circle mr-1"></i>O slug é gerado automaticamente a partir do título.</small>
                    </div>
                </div>
            </div>

            <!-- Card de Tags -->
            <div class="card shadow mb-4 border-left-dark">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-tags mr-2"></i><?= __('Tags') ?></h6>
                </div>
                <div class="card-body p-0">
                    <div class="tags-container p-3 bg-gray-100" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach ($tags as $id => $name): ?>
                            <div class="custom-control custom-checkbox small mb-2 hov-bg rounded p-1 pl-4 bg-white border shadow-xs">
                                <?= $this->Form->checkbox("tags._ids.$id", [
                                    'value' => $id,
                                    'checked' => in_array($id, collection($post->tags ?? [])->extract('id')->toList()),
                                    'class' => 'custom-control-input',
                                    'id' => 'tag-' . $id
                                ]) ?>
                                <label class="custom-control-label fw-bold" for="tag-<?= $id ?>"><?= h($name) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .hov-bg:hover { border-color: #4e73df !important; background-color: #f8f9fc; }
    .decoration-none:hover { text-decoration: none; }
    .card-img-top { border-radius: calc(0.35rem - 1px) calc(0.35rem - 1px) 0 0; }
    .shadow-xs { shadow: 0 .125rem .25rem rgba(0,0,0,.075) !important; }
</style>

<?php $this->Html->scriptStart(['block' => 'script_bottom']); ?>
jQuery(document).ready(function($) {
    if (typeof $.fn.summernote !== 'undefined') {
        $('#summernote').summernote({
            placeholder: 'Use o ícone de corrente para links. Ex: Clique aqui para se inscrever.',
            tabsize: 2,
            height: 500,
            lang: 'pt-BR',
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    } else {
        console.error('Summernote Lite não carregado no edit.');
    }
});
<?php $this->Html->scriptEnd(); ?>