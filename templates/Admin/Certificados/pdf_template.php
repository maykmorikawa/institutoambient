<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Certificado</title>
</head>
<body>
    <?= $this->element('certificate_layout', [
        'certificado' => $certificado,
        'dataCompleta' => $dataCompleta,
        'qrCodeDataUri' => $qrCodeDataUri,
        'bgCertificadoUrl' => $bgCertificadoUrl
    ]) ?>
</body>
</html>