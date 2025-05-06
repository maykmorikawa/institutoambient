<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'Sistema Instituto Ambiente';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Instituto Ambient</title>

    <!-- Custom fonts for this template-->
    <link href="<?= WWW; ?>/dash/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
   
   
    <!-- Custom styles for this template-->
    <link href="<?= WWW; ?>/dash/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?= $this->element('sidebar'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <?= $this->element('topbar'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    <?= $this->fetch('content') ?>

                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <?= $this->element('footer'); ?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <?= $this->element('modal'); ?>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= WWW; ?>/dash/vendor/jquery/jquery.min.js"></script>
    <script src="<?= WWW; ?>/dash/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= WWW; ?>/dash/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= WWW; ?>/dash/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="<?= WWW; ?>/dash/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="<?= WWW; ?>/dash/js/demo/chart-area-demo.js"></script>
    <script src="<?= WWW; ?>/dash/js/demo/chart-pie-demo.js"></script>
    <script src="<?= WWW; ?>/dash/js/demo/datatables-demo.js"></script>
    
</body>

</html>