<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>

<div class="documents add content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= __('Novo Documento PDF') ?></h1>
        <?= $this->Html->link('<i class="fas fa-arrow-left fa-sm text-white-50 mr-2"></i> Voltar à Lista', ['action' => 'index'], ['class' => 'd-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
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
                            'placeholder' => 'Digite o nome do documento...'
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
                    <div class="upload-area border-dashed rounded p-4 bg-light">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <h5>Selecione o arquivo PDF</h5>
                        <p class="text-muted mb-3 small">O arquivo será salvo na pasta de downloads do site.</p>
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
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-paper-plane mr-2"></i><?= __('Publicação') ?></h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">Ao salvar, o documento ficará disponível para download na página de Transparência/Documentos.</p>
                </div>
                <div class="card-footer bg-light border-top-0 py-3">
                    <button type="submit" class="btn btn-success btn-icon-split btn-block shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold w-100"><?= __('Salvar Documento') ?></span>
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
