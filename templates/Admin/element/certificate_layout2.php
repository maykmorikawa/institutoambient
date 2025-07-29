<?php
// Renomeia as variáveis para facilitar, já que elas vêm de formas diferentes
$aluno = $certificado->aluno;
$atividade = $certificado->atividade;
?>
<style>
    /* Estilos do certificado aqui ... */
    body, html { margin: 0; padding: 0; }
    .certificate-container {
        width: 1122px; /* A4 landscape em ~96dpi */
        height: 793px;
        position: relative;
        font-family: sans-serif;
        text-align: center;
        background-image: url('/img/uploads/fundo_certificado_2.png');
        background-size: cover;
        background-position: center;
        color: #333;
    }
    
    .content-wrapper { padding: 80px; }
    h1 { font-size: 48px; margin-bottom: 40px; }
    p { font-size: 18px; line-height: 1.6; margin: 20px 40px; }
    .nome-aluno { font-size: 36px; font-weight: bold; margin: 40px 0; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 20px 0; color: #000;}
    .footer { position: absolute; bottom: 209px; left: -2px; right: 80px; height: 120px; text-align: left;}
    .qr-code { float: left; }
    .texto-verificacao { float: left; margin-left: 20px; font-size: 12px; }
</style>

<div class="certificate-container" style="background-image: url('<?= h($bgCertificadoUrl) ?>'); background-size: cover; background-position: center;">
    <div class="content-wrapper">
        
        <?php if (empty($ocultarNome)): ?>
            <p>Certificamos que</p>
            <div class="nome-aluno">
                <?= h($aluno->nome_completo) ?>
            </div>
        <?php endif; ?>

        <?php if (empty($ocultarAtividade)): ?>
            <p>
                concluiu com sucesso a atividade <strong><?= h($atividade->nome) ?></strong>,
                com carga horária total de <strong><?= h($certificado->carga_horaria_total) ?> horas</strong>.
            </p>
        <?php endif; ?>

        <?php if (empty($ocultarData)): ?>
            <p><?= h($dataCompleta) ?></p>
        <?php endif; ?>

        <?php if (empty($ocultarRodape)): ?>
            <div class="footer">
                <?php if (!empty($qrCodeDataUri)): ?>
                    <div class="qr-code">
                        <img src="<?= $qrCodeDataUri ?>" alt="QR Code" style="width: 120px; height: 120px;">
                    </div>
                <?php endif; ?>
                <div class="texto-verificacao">
                    <p>Para verificar a autenticidade deste certificado, aponte a câmera do seu celular para o QR Code ao lado.</p>
                    <p><strong>Código:</strong> <?= h($certificado->codigo_autenticacao) ?></p>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
