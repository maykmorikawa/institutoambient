<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 * @var array $categoryTree
 * @var array $users
 * @var array $tags
 */
?>

<div class="posts add content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Novo Post') ?></h1>
        <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'd-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
    </div>

    <?= $this->Form->create($post, ['enctype' => 'multipart/form-data', 'class' => 'user']) ?>
    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Conteúdo do Post') ?></h6>
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
                        <label class="font-weight-bold small text-uppercase"><?= __('Conteúdo') ?></label>
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
                            'class' => 'form-control',
                            'rows' => 3,
                            'placeholder' => 'Uma breve descrição do post...'
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Imagens do Post') ?></h6>
                </div>
                <div class="card-body text-center py-5">
                    <div class="upload-area border-dashed rounded p-4 bg-light">
                        <i class="fas fa-cloud-upload-alt fa-3x text-gray-400 mb-3"></i>
                        <h5>Selecione as imagens para o post</h5>
                        <p class="text-muted mb-3 small">Você pode selecionar múltiplos arquivos para a galeria.</p>
                        <?= $this->Form->control('images[]', [
                            'label' => false,
                            'type' => 'file',
                            'multiple' => true,
                            'class' => 'form-control-file d-inline-block',
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral (Sidebar) -->
        <div class="col-lg-4">
            <!-- Card de Publicação -->
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-paper-plane mr-2"></i><?= __('Publicação') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-uppercase"><?= __('Status') ?></label>
                        <?= $this->Form->control('status', [
                            'label' => false,
                            'options' => [
                                'rascunho' => 'Rascunho',
                                'publicado' => 'Publicado'
                            ],
                            'class' => 'custom-select border-left-info font-weight-bold',
                        ]) ?>
                    </div>

                    <div class="form-group mb-3">
                        <label class="small font-weight-bold text-uppercase"><?= __('Data de Publicação') ?></label>
                        <?= $this->Form->control('published', [
                            'label' => false,
                            'class' => 'form-control small',
                            'empty' => true
                        ]) ?>
                    </div>

                    <div class="form-group mb-0">
                        <label class="small font-weight-bold text-uppercase"><?= __('Autor') ?></label>
                        <?= $this->Form->control('user_id', [
                            'label' => false,
                            'options' => $users,
                            'class' => 'custom-select border-left-secondary',
                        ]) ?>
                    </div>
                </div>
                <div class="card-footer bg-light border-top-0 py-3">
                    <button type="submit" class="btn btn-primary btn-icon-split btn-block shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold w-100"><?= __('Salvar Postagem') ?></span>
                    </button>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-link btn-block btn-sm text-secondary decoration-none']) ?>
                </div>
            </div>

            <!-- Card de Organização -->
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-folder mr-2"></i><?= __('Organização') ?></h6>
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
                        <label class="small font-weight-bold text-uppercase"><?= __('Slug (URL Amigável)') ?></label>
                        <?= $this->Form->control('slug', [
                            'label' => false,
                            'class' => 'form-control form-control-sm',
                            'placeholder' => 'deixe em branco para gerar automático'
                        ]) ?>
                    </div>
                </div>
            </div>

            <!-- Card de Tags -->
            <div class="card shadow mb-4 border-left-dark">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-dark"><i class="fas fa-tags mr-2"></i><?= __('Tags') ?></h6>
                </div>
                <div class="card-body p-0">
                    <div class="tags-container p-3" style="max-height: 250px; overflow-y: auto;">
                        <?php foreach ($tags as $id => $name): ?>
                            <div class="custom-control custom-checkbox small mb-2 hov-bg rounded p-1 pl-4">
                                <?= $this->Form->checkbox("tags._ids.$id", [
                                    'value' => $id,
                                    'class' => 'custom-control-input',
                                    'id' => 'tag-' . $id
                                ]) ?>
                                <label class="custom-control-label" for="tag-<?= $id ?>"><?= h($name) ?></label>
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
    .hov-bg:hover { background-color: #f8f9fc; }
    .decoration-none:hover { text-decoration: none; }
</style>

<script>
    $(document).ready(function() {
        if (typeof $.fn.summernote !== 'undefined') {
            $('#summernote').summernote({
                placeholder: 'Escreva o conteúdo do seu post aqui. DICA: Use o ícone de corrente (Link) para adicionar botões de inscrição ou outros sites.',
                tabsize: 2,
                height: 400,
                lang: 'pt-BR',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        }
    });
</script>