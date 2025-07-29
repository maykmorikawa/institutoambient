<?php
/**
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\Atividade $atividade
 * @var \App\Model\Entity\Certificado $certificado
 * @var string $dataCompleta
 * @var string $qrCodeDataUri
 * @var string $bgCertificadoUrl
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
            /* Define a imagem de fundo */
            background-image: url("<?= $bgCertificadoUrl ?>");
            background-size: cover; /* Faz a imagem cobrir toda a página */
            background-position: center;
            background-repeat: no-repeat;
            
            /* Estilos gerais */
            font-family: sans-serif;
            text-align: center;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 50px;
        }
        .content-wrapper {
            /* Este container ajuda a posicionar o texto sobre o fundo */
            position: relative;
            z-index: 10;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 40px;
            color: #333; /* Cor escura para boa legibilidade */
        }
        p {
            font-size: 18px;
            line-height: 1.6;
            margin: 20px 40px;
            color: #333;
        }
        .nome-aluno {
            font-size: 36px;
            font-weight: bold;
            margin: 40px 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
            padding: 20px 0;
            color: #000;
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
<body>
    <div class="content-wrapper">
        <h1>CERTIFICADO DE CONCLUSÃO</h1>
        <p>Certificamos que</p>
        <div class="nome-aluno">
            <?= h($aluno->nome) ?>
        </div>
        <p>
            concluiu com sucesso a atividade <strong><?= h($atividade->nome) ?></strong>,
            com carga horária total de <strong><?= h($certificado->carga_horaria_total) ?> horas</strong>.
        </p>
        <p><?= h($dataCompleta) ?></p>
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
    </div>
</body>
</html>