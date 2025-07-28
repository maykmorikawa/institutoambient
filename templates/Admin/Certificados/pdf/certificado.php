<?php
/**
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\Atividade $atividade
 * @var \App\Model\Entity\Certificado $certificado
 * @var string $dataCompleta
 * @var string $qrCodeDataUri
 * @var string $bgCertificadoUrl // <-- [NOVO] Variável para a imagem de fundo
 */
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: sans-serif;
            text-align: center;
            /* A borda foi removida para dar lugar à imagem de fundo */
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 50px;
        }
        /* [NOVO] Estilo para o container do conteúdo, para que fique sobre a imagem */
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 40px;
        }
        p {
            font-size: 18px;
            line-height: 1.6;
            margin: 20px 40px;
        }
        .nome-aluno {
            font-size: 36px;
            font-weight: bold;
            margin: 40px 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 20px 0;
        }
        .footer {
            position: absolute;
            bottom: 40px;
            left: 40px;
            right: 40px;
            height: 150px;
        }
        .qr-code { float: left; }
        .texto-verificacao { float: left; margin-left: 20px; text-align: left; font-size: 12px; }
    </style>
</head>
<body style="background-image: url('<?= $bgCertificadoUrl ?>'); background-size: cover; background-position: center;">

    <div class="content-wrapper">

        <h1>CERTIFICADO DE CONCLUSÃO</h1>

        <p>Certificamos que</p>

        <div class="nome-aluno">
            <?= h($aluno->nome_completo) ?>
        </div>

        <p>
            concluiu com sucesso a atividade <strong><?= h($atividade->nome) ?></strong>,
            com carga horária total de <strong><?= h($certificado->carga_horaria_total) ?> horas</strong>.
        </p>

        <p><?= h($dataCompleta) ?></p>

        <div class="footer">
            <?php if (!empty($qrCodeDataUri)): ?>
                <div class="qr-code">
                    <img src="<?= $qrCodeDataUri ?>" alt="QR Code de Verificação" style="width: 120px; height: 120px;">
                </div>
            <?php endif; ?>
            <div class="texto-verificacao">
                <p>Para verificar a autenticidade deste certificado, aponte a câmera do seu celular para o QR Code ao lado ou acesse o link de verificação.</p>
                <p><strong>Código:</strong> <?= h($certificado->codigo_autenticacao) ?></p>
            </div>
        </div>

    </div>

</body>
</html>