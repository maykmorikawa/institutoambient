<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 * @var \Cake\Collection\CollectionInterface|string[] $parentCategories
 */
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-success">
                    <i class="fas fa-folder-plus me-2"></i><?= __('Nova Categoria') ?>
                </h6>
                <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            </div>
            <div class="card-body py-4">
                <?= $this->Form->create($category, ['class' => 'user']) ?>
                
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Nome da Categoria') ?></label>
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control border-left-success shadow-sm',
                            'placeholder' => 'Ex: Meio Ambiente, Editais...'
                        ]) ?>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Slug (URL)') ?></label>
                        <?= $this->Form->control('slug', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'placeholder' => 'meio-ambiente'
                        ]) ?>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold text-dark small text-uppercase"><?= __('Categoria Pai') ?></label>
                    <?= $this->Form->control('parent_id', [
                        'label' => false,
                        'options' => $parentCategories,
                        'empty' => 'Nenhuma (Categoria Principal)',
                        'class' => 'form-control custom-select shadow-sm'
                    ]) ?>
                    <small class="form-text text-muted">Selecione uma categoria para aninhá-la sob outra já existente.</small>
                </div>

                <div class="form-group mb-4">
                    <label class="font-weight-bold text-dark small text-uppercase"><?= __('Descrição') ?></label>
                    <?= $this->Form->control('description', [
                        'label' => false,
                        'class' => 'form-control shadow-sm',
                        'rows' => 3,
                        'placeholder' => 'Opcional. Uma breve descrição do conteúdo desta categoria.'
                    ]) ?>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success btn-icon-split shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold px-4"><?= __('Salvar Categoria') ?></span>
                    </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
