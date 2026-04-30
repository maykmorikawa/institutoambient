<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Video $video
 */
?>

<div class="videos add content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Novo Vídeo') ?></h1>
        <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'd-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
    </div>

    <?= $this->Form->create($video, ['enctype' => 'multipart/form-data', 'class' => 'user']) ?>
    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Informações do Vídeo') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Título do Vídeo') ?></label>
                        <?= $this->Form->control('title', [
                            'label' => false,
                            'class' => 'form-control form-control-lg border-left-primary shadow-sm',
                            'placeholder' => 'Digite o título aqui...'
                        ]) ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold small text-uppercase"><?= __('URL do Vídeo (YouTube)') ?></label>
                        <?= $this->Form->control('video_url', [
                            'label' => false,
                            'class' => 'form-control',
                            'placeholder' => 'https://www.youtube.com/watch?v=...'
                        ]) ?>
                        <small class="text-muted">Cole o link completo do vídeo do YouTube.</small>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Miniatura / Capa') ?></h6>
                </div>
                <div class="card-body text-center py-5">
                    <div class="upload-area border-dashed rounded p-4 bg-light">
                        <i class="fas fa-image fa-3x text-gray-400 mb-3"></i>
                        <h5>Selecione a imagem de fundo</h5>
                        <p class="text-muted mb-3 small">Esta imagem aparecerá como capa do vídeo na galeria.</p>
                        <?= $this->Form->control('background_image_file', [
                            'label' => false,
                            'type' => 'file',
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
                    <p class="small text-muted">Ao salvar, o vídeo ficará disponível imediatamente na galeria do site.</p>
                </div>
                <div class="card-footer bg-light border-top-0 py-3">
                    <button type="submit" class="btn btn-primary btn-icon-split btn-block shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold w-100"><?= __('Salvar Vídeo') ?></span>
                    </button>
                    <?= $this->Html->link(__('Cancelar'), ['action' => 'index'], ['class' => 'btn btn-link btn-block btn-sm text-secondary decoration-none']) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end() ?>
</div>

<style>
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .decoration-none:hover { text-decoration: none; }
</style>
