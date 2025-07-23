<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \App\Model\Entity\Atividade $atividade
 * @var \App\Model\Entity\Certificado $certificado
 * @var string $verificationUrl
 * @var string $qrCodeDataUri
 */

// Caminho base para as suas logos e imagens de fundo dentro de webroot/img/
$imagePath = 'img/'; // Assumindo que você terá uma pasta 'img' dentro de webroot

// URLs das suas logos e imagens de fundo
// Substitua 'seus_nomes_de_arquivo.png' pelos nomes reais dos arquivos que você fez upload
$bgCertificadoPage1 = $this->Url->image($imagePath . 'backgrounds/certificado_fundo_page1.png', ['fullBase' => true]);
$bgCertificadoPage2 = $this->Url->image($imagePath . 'backgrounds/certificado_fundo_page2.png', ['fullBase' => true]); // Se tiver fundo para a página 2

// Logos do rodapé (se não estiverem na imagem de fundo e forem dinâmicas)
$logoEquatorial = $this->Url->image($imagePath . 'logos/equatorial_energia.png', ['fullBase' => true]);
$logoComdac = $this->Url->image($imagePath . 'logos/comdac.png', ['fullBase' => true]);
$logoInstitutoAmbientTexto = $this->Url->image($imagePath . 'logos/instituto_ambient_texto.png', ['fullBase' => true]);
$logoTrabalhoLadoLado = $this->Url->image($imagePath . 'logos/trabalho_lado_lado.png', ['fullBase' => true]);

// Formatação da data conforme o PDF original
$dataEmissaoFormatada = $certificado->data_emissao->format('d \d\e F \d\e Y');
// Para traduzir o mês, certifique-se que o locale do CakePHP está configurado para 'pt-BR'
// Ex: $dataEmissaoFormatada = $certificado->data_emissao->i18nFormat('dd \'de\' MMMM \'de\' yyyy', 'pt-BR');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificado de Conclusão</title>
    <style>
        /* Estilos CSS para o certificado */
        @page {
            margin: 0; /* Remove margens padrão da página */
        }
        body {
            font-family: 'Arial', sans-serif; /* Fonte comum para certificados */
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .certificate-page {
            width: 297mm; /* Largura A4 paisagem */
            height: 210mm; /* Altura A4 paisagem */
            position: relative;
            overflow: hidden;
            background-size: cover; /* Ajusta a imagem para cobrir toda a área */
            background-position: center center; /* Centraliza a imagem */
            background-repeat: no-repeat; /* Não repete a imagem */
        }

        /* Estilos para o conteúdo sobreposto na Página 1 */
        .content-overlay-page1 {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            /* Use padding ou ajuste as posições absolutas dos elementos internos */
            /* padding: 20mm 30mm; */ /* Exemplo, pode ser ajustado */
            box-sizing: border-box;
        }

        /* Posicionamento dos elementos dinâmicos na Página 1 */
        .certificate-title-overlay {
            position: absolute;
            top: 50mm; /* Ajuste conforme seu design de fundo */
            width: 100%;
            text-align: center;
            color: #000080;
            font-size: 48px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .institute-text-overlay {
            position: absolute;
            top: 90mm; /* Ajuste */
            width: 100%;
            text-align: center;
            color: #333;
            font-size: 16px;
            line-height: 1.4;
        }
        .student-name-overlay {
            position: absolute;
            top: 110mm; /* Ajuste */
            width: 100%;
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            color: #0056b3;
        }
        .course-details-overlay {
            position: absolute;
            top: 130mm; /* Ajuste */
            width: 100%;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #555;
        }
        .course-hours-overlay {
            position: absolute;
            top: 145mm; /* Ajuste */
            width: 100%;
            text-align: center;
            font-size: 20px;
            color: #333;
        }
        .date-location-overlay {
            position: absolute;
            top: 160mm; /* Ajuste */
            width: 100%;
            text-align: center;
            font-size: 16px;
            color: #666;
        }

        /* Área de Assinaturas (Posicionamento absoluto) */
        .signature-block-overlay {
            position: absolute;
            bottom: 60mm; /* Ajuste */
            left: 0;
            width: 100%;
            text-align: center;
        }
        .signature-line-wrapper-overlay {
            display: inline-block;
            width: 45%;
            margin: 0 2%;
            vertical-align: top;
            text-align: center;
        }
        .signature-line-overlay {
            border-top: 1px solid #666; /* Se a linha não estiver na imagem de fundo */
            padding-top: 5px;
            font-size: 14px;
            color: #444;
            margin-top: 10mm;
        }
        .signature-name-overlay {
            font-weight: bold;
            margin-top: 5px;
        }
        .signature-role-overlay {
            font-size: 12px;
        }

        /* Selo de Autenticação / QR Code (Posicionamento absoluto) */
        .auth-seal-overlay {
            position: absolute;
            bottom: 20mm; /* Ajuste */
            right: 30mm; /* Ajuste */
            text-align: center;
            width: 60mm;
        }
        .auth-seal-overlay img {
            width: 30mm;
            height: 30mm;
            margin-bottom: 3mm;
            border: 1px solid #ddd;
        }
        .auth-code-overlay {
            font-size: 10px;
            color: #333;
            word-break: break-all;
            margin-bottom: 2mm;
        }
        .auth-url-overlay {
            font-size: 9px;
            color: #007bff;
            text-decoration: none;
            display: block;
        }

        /* Logos Inferiores (Rodapé da Página 1 - Posicionamento absoluto) */
        .footer-logos-page1-overlay {
            position: absolute;
            bottom: 20mm; /* Ajuste */
            left: 30mm; /* Ajuste */
            width: calc(100% - 60mm - 30mm); /* Largura para acomodar o QR Code */
            text-align: left;
        }
        .footer-logos-page1-overlay img {
            max-height: 25mm;
            width: auto;
            margin-right: 10mm;
            vertical-align: middle;
        }

        /* Conteúdo Programático (Página 2) */
        .program-content-page {
            page-break-before: always;
            width: 297mm;
            height: 210mm;
            box-sizing: border-box;
            padding: 20mm 30mm;
            position: relative;
            overflow: hidden;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }
        .program-title-overlay {
            position: absolute;
            top: 20mm; /* Ajuste */
            width: 100%;
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #000080;
        }
        .program-list-overlay {
            position: absolute;
            top: 50mm; /* Ajuste */
            left: 30mm; /* Ajuste */
            width: calc(100% - 60mm); /* Ajuste a largura */
            text-align: left;
            font-size: 16px;
            line-height: 1.6;
        }
        .program-list-overlay ul {
            list-style-type: disc;
            padding-left: 20px;
            margin: 0;
        }
        .program-list-overlay li {
            margin-bottom: 5px;
        }

        /* Logos Inferiores (Rodapé da Página 2 - Posicionamento absoluto) */
        .program-footer-logos-overlay {
            position: absolute;
            bottom: 20mm;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            text-align: center;
        }
        .program-footer-logos-overlay img {
            max-height: 25mm;
            width: auto;
            margin: 0 5mm;
            vertical-align: middle;
        }
        .cnpj-info-overlay {
            position: absolute;
            bottom: 10mm;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: #666;
            text-align: center;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Página 1: Certificado Principal -->
    <div class="certificate-page" style="background-image: url('<?= $bgCertificadoPage1 ?>');">
        <div class="content-overlay-page1">
            <!-- Conteúdo dinâmico sobreposto -->
            <h1 class="certificate-title-overlay">Certificado</h1>
            <p class="institute-text-overlay">O Instituto Ambient por meio do Projeto "Trabalho Lado a Lado" em parceria com a "Equatorial", certifica que</p>

            <span class="student-name-overlay"><?= h($aluno->nome_completo) ?></span>
            <p class="course-details-overlay">Concluiu o curso de "<?= h($atividade->nome) ?>"</p>
            <p class="course-hours-overlay">com carga horária de **<?= h($certificado->carga_horaria_total) ?> horas**.</p>

            <p class="date-location-overlay">
                Belém, <?= $dataEmissaoFormatada ?>
            </p>

            <!-- Área de Assinaturas -->
            <div class="signature-block-overlay">
                <div class="signature-line-wrapper-overlay">
                    <p>_________________________</p>
                    <p class="signature-name-overlay">MURILO MONTEIRO DE SOUZA</p>
                    <p class="signature-role-overlay">Diretor(a) do Instituto</p>
                </div>
                <div class="signature-line-wrapper-overlay">
                    <p>_________________________</p>
                    <p class="signature-name-overlay">Nome do Coordenador</p>
                    <p class="signature-role-overlay">Coordenador(a) da Atividade</p>
                </div>
            </div>

            <!-- Selo de Autenticação Online (QR Code) -->
            <div class="auth-seal-overlay">
                <?php if (!empty($qrCodeDataUri)): ?>
                    <img src="<?= $qrCodeDataUri ?>" alt="QR Code de Autenticação">
                <?php endif; ?>
                <p class="auth-code-overlay">Código: <?= h($certificado->codigo_autenticacao) ?></p>
                <a href="<?= h($verificationUrl) ?>" class="auth-url-overlay" target="_blank">Verificar Autenticidade Online</a>
            </div>

            <!-- Logos Inferiores (Rodapé da Página 1) -->
            <div class="footer-logos-page1-overlay">
                <img src="<?= $logoEquatorial ?>" alt="Logo Equatorial Energia">
                <img src="<?= $logoComdac ?>" alt="Logo COMDAC">
                <img src="<?= $logoInstitutoAmbientTexto ?>" alt="Logo Instituto Ambient">
                <img src="<?= $logoTrabalhoLadoLado ?>" alt="Logo Trabalho Lado a Lado">
            </div>
        </div>
    </div>

    <!-- Página 2: Conteúdo Programático -->
    <div class="program-content-page" style="background-image: url('<?= $bgCertificadoPage2 ?>');">
        <h1 class="program-title-overlay">CONTEÚDO PROGRAMÁTICO</h1>
        <div class="program-list-overlay">
            <?php if (!empty($atividade->conteudo_programatico)): ?>
                <?= $this->Text->autoParagraph($atividade->conteudo_programatico); ?>
            <?php else: ?>
                <p>Nenhum conteúdo programático definido para esta atividade.</p>
            <?php endif; ?>
        </div>

        <!-- Logos Inferiores (Rodapé da Página 2) -->
        <div class="program-footer-logos-overlay">
            <img src="<?= $logoEquatorial ?>" alt="Logo Equatorial Energia">
            <img src="<?= $logoComdac ?>" alt="Logo COMDAC">
            <img src="<?= $logoInstitutoAmbientTexto ?>" alt="Logo Instituto Ambient">
            <img src="<?= $logoTrabalhoLadoLado ?>" alt="Logo Trabalho Lado a Lado">
        </div>
        <div class="cnpj-info-overlay">
            Certificado registrado pelo INSTITUTO AMBIENT<br>
            Desenvolvimento Social com Sustentabilidade<br>
            CNPJ: 16.791.646/0001-74
        </div>
    </div>
</body>
</html>
