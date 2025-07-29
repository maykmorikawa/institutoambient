<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pré-visualização do Certificado</h3>
                <div class="card-tools">
                    <?= $this->Html->link(
                        __('Baixar PDF'),
                        ['action' => 'gerarPdf', $certificado->id],
                        ['class' => 'btn btn-success', 'target' => '_blank']
                    ) ?>
                </div>
            </div>
            <div class="card-body"
                style="background-color: #ffffff; padding: 20px; display: flex; justify-content: center; align-items: center;">
                <?= $this->element('certificate_layout', [
                    'certificado' => $certificado,
                    'dataCompleta' => $dataCompleta,
                    'qrCodeDataUri' => null,
                    'bgCertificadoUrl' => '/img/uploads/fundo_certificado_1.png',
                    'ocultarRodape' => true,
                    'ocultarAtividade' => false
                ]) ?>
            </div>

            <div class="card-body"
                style="background-color: #ffffff; padding: 20px; display: flex; justify-content: center; align-items: center;">
                <?= $this->element('certificate_layout', [
                    'certificado' => $certificado,
                    'dataCompleta' => $dataCompleta,
                    'qrCodeDataUri' => $qrCodeDataUri,
                    'bgCertificadoUrl' => '/img/uploads/fundo_certificado_2.png',
                    'ocultarNome' => true,
                    'ocultarAtividade' => true,
                    'ocultarData' => true
                ]) ?>
            </div>

        </div>
    </div>
</div>