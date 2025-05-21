<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprovante de Inscrição</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; margin: 20px; }
        @media print {
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <?= $this->fetch('content') ?>
</body>
</html>
