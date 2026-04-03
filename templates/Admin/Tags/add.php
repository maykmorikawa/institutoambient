<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 * @var \Cake\Collection\CollectionInterface|string[] $posts
 */
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-tag me-2"></i><?= __('Nova Tag') ?>
                </h6>
                <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            </div>
            <div class="card-body py-4">
                <?= $this->Form->create($tag, ['class' => 'user']) ?>
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Nome da Tag') ?></label>
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control border-left-primary shadow-sm',
                            'placeholder' => 'Ex: Sustentabilidade, Eventos...'
                        ]) ?>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Slug (URL)') ?></label>
                        <?= $this->Form->control('slug', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'placeholder' => 'sustentabilidade-2024'
                        ]) ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold text-dark small text-uppercase"><?= __('Vincular a Postagens') ?></label>
                    <?= $this->Form->control('posts._ids', [
                        'options' => $posts,
                        'label' => false,
                        'class' => 'form-control custom-select-multiple',
                        'multiple' => true,
                        'size' => 10,
                        'style' => 'height: auto;'
                    ]) ?>
                    <small class="form-text text-muted">Use Ctrl + Clique para selecionar múltiplas postagens.</small>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-icon-split shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold px-4"><?= __('Salvar Tag') ?></span>
                    </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-select-multiple {
        padding: 0.5rem;
        border-radius: 0.35rem;
        border: 1px solid #d1d3e2;
    }
    .custom-select-multiple option {
        padding: 0.5rem 1rem;
        border-bottom: 1px solid #f8f9fc;
    }
    .custom-select-multiple option:hover {
        background-color: #eaecf4;
    }
</style>