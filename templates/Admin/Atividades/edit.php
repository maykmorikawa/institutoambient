<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 * @var string[]|\Cake\Collection\CollectionInterface $projetos
 */
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><?= __('Editar Atividade') ?></h4>
            </div>
            <div class="card-body">
                <?= $this->Form->create($atividade) ?>
                    <fieldset>
                        <legend><?= __('Informações da Atividade') ?></legend>
                        <div class="mb-3">
                            <?= $this->Form->control('projeto_id', ['options' => $projetos, 'class' => 'form-control', 'label' => 'Projeto']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('titulo', ['class' => 'form-control', 'label' => 'Título']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('descricao', ['class' => 'form-control', 'label' => 'Descrição', 'type' => 'textarea']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('slug', ['class' => 'form-control', 'label' => 'Slug']) ?>
                        </div>
                        <div class="mb-3">
                            <?= $this->Form->control('link_inscricao', ['class' => 'form-control', 'label' => 'Link Inscrição']) ?>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <?= $this->Form->checkbox('publicado', [
                                    'class' => 'form-check-input',
                                    'id' => 'publicado'
                                ]) ?>
                                <label class="form-check-label" for="publicado">
                                    <?= __('Publicado') ?>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    <div class="d-grid">
                        <?= $this->Form->button(__('Salvar Alterações'), ['class' => 'btn btn-primary']) ?>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>