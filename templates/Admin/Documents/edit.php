<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>

<div class="documents edit content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Editar Documento') ?></h1>
        <div class="btn-group">
            <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm mr-2"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
            <?= $this->Form->postLink(
                '<i class="fas fa-trash fa-sm mr-2"></i> Excluir',
                ['action' => 'delete', $document->id],
                ['confirm' => __('Realmente deseja excluir este documento?'), 'class' => 'btn btn-sm btn-danger shadow-sm', 'escape' => false]
            ) ?>
        </div>
    </div>

    <?= $this->Form->create($document, ['type' => 'file', 'class' => 'user']) ?>
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Informações do Documento') ?></h6>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Título do Documento') ?></label>
                        <?= $this->Form->control('title', [
                            'label' => false,
                            'class' => 'form-control form-control-lg border-left-primary shadow-sm',
                        ]) ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-weight-bold small text-uppercase"><?= __('Categoria') ?></label>
                        <?= $this->Form->control('category', [
                            'label' => false,
                            'type' => 'select',
                            'options' => [
                                'documento' => 'Documentos do IA',
                                'relatorio' => 'Relatórios de Atividades'
                            ],
                            'class' => 'form-control',
                        ]) ?>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Arquivo PDF') ?></h6>
                </div>
                <div class="card-body text-center py-5">
                    <?php if ($document->filename): ?>
                        <div class="mb-4">
                            <i class="fas fa-file-pdf fa-4x text-danger mb-2"></i>
                            <div class="text-dark fw-bold"><?= h($document->filename) ?></div>
                            <a href="<?= $this->Url->build('/uploads/pdfs/' . $document->filename) ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-eye me-1"></i>Ver arquivo atual
                            </a>
                        </div>
                        <hr>
                    <?php endif; ?>

                    <div class="upload-area border-dashed rounded p-4 bg-light mt-3">
                        <i class="fas fa-cloud-upload-alt fa-2x text-gray-400 mb-2"></i>
                        <h5><?= $document->filename ? 'Substituir arquivo' : 'Selecionar arquivo PDF' ?></h5>
                        <p class="text-muted mb-3 small">Selecione um novo arquivo se desejar substituir o atual.</p>
                        <?= $this->Form->control('pdf_file', [
                            'label' => false,
                            'type' => 'file',
                            'class' => 'form-control-file d-inline-block',
                            'accept' => 'application/pdf'
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-sync-alt mr-2"></i><?= __('Atualização') ?></h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">As alterações serão refletidas imediatamente no site.</p>
                    <hr>
                    <div class="small">
                        <strong>Criado em:</strong> <?= $document->created->format('d/m/Y H:i') ?><br>
                        <strong>Modificado em:</strong> <?= $document->modified->format('d/m/Y H:i') ?>
                    </div>
                </div>
                <div class="card-footer bg-light border-top-0 py-3">
                    <button type="submit" class="btn btn-info btn-icon-split btn-block shadow-sm text-white">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold w-100"><?= __('Atualizar Documento') ?></span>
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
