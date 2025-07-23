<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\Atividade $atividade
 * @var \App\Model\Entity\Certificado $certificado
 * @var string $verificationUrl
 * @var string $qrCodeDataUri
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado de Conclusão</title>
    <style>
        /* Estilos CSS para o certificado */
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .certificate-container {
            width: 270mm; /* A4 landscape width (297mm) - margins */
            height: 180mm; /* A4 landscape height (210mm) - margins */
            margin: 15mm auto; /* Margens para centralizar */
            border: 5px solid #007bff; /* Borda principal */
            padding: 20mm;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }
        .header {
            margin-bottom: 20mm;
        }
        .header h1 {
            color: #007bff;
            font-size: 48px;
            margin-bottom: 10px;
        }
        .header h2 {
            color: #343a40;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .content {
            font-size: 20px;
            line-height: 1.6;
            margin-bottom: 30mm;
        }
        .content p {
            margin-bottom: 10px;
        }
        .student-name {
            font-size: 36px;
            font-weight: bold;
            color: #28a745; /* Cor verde para o nome do aluno */
            margin-bottom: 15px;
        }
        .activity-details {
            font-size: 24px;
            margin-bottom: 15px;
        }
        .date {
            font-size: 18px;
            margin-top: 30px;
        }
        .signature-area {
            display: flex;
            justify-content: space-around;
            margin-top: 40mm;
        }
        .signature-line {
            border-top: 1px solid #343a40;
            width: 30%;
            padding-top: 5px;
            font-size: 14px;
        }
        .seal-area {
            position: absolute;
            bottom: 15mm;
            right: 15mm;
            text-align: right;
        }
        .seal-area img {
            width: 80px; /* Tamanho do QR code */
            height: 80px;
            margin-bottom: 5px;
        }
        .seal-text {
            font-size: 10px;
            color: #6c757d;
        }
        .footer-text {
            position: absolute;
            bottom: 5mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="header">
            <h1>CERTIFICADO</h1>
            <h2><?= h('INSTITUTO AMBIENTAL') ?></h2>
        </div>

        <div class="content">
            <p>Certificamos que</p>
            <p class="student-name"><?= h($aluno->nome_completo) ?></p>
            <p>concluiu com sucesso a atividade</p>
            <p class="activity-details">"<?= h($atividade->nome) ?>"</p>
            <p>com carga horária total de **<?= h($certificado->carga_horaria_total) ?> horas**.</p>
        </div>

        <div class="date">
            <?= __('Emitido em') ?>: <?= $certificado->data_emissao->format('d/m/Y') ?>
        </div>

        <!-- Área de Assinaturas (Exemplo) -->
        <div class="signature-area">
            <div class="signature-line">
                <p>_________________________</p>
                <p>Diretor(a) do Instituto</p>
            </div>
            <div class="signature-line">
                <p>_________________________</p>
                <p>Coordenador(a) da Atividade</p>
            </div>
        </div>

        <!-- Selo de Autenticação Online (QR Code) -->
        <div class="seal-area">
            <?php if (!empty($qrCodeDataUri)): ?>
                <img src="<?= $qrCodeDataUri ?>" alt="QR Code de Autenticação">
            <?php endif; ?>
            <p class="seal-text">Código de Autenticação: <?= h($certificado->codigo_autenticacao) ?></p>
            <p class="seal-text">Verifique em: <?= h($verificationUrl) ?></p>
        </div>

        <div class="footer-text">
            Este certificado é válido mediante autenticação online.
        </div>
    </div>
</body>
</html>