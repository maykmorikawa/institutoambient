<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- Primary Meta Tags -->
  <title>Sistema Easyreg</title>
  <meta name="title" content="Sistema Easyreg" />
  <meta name="description" content="" />
  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://easyreg.net.br" />
  <meta property="og:title" content="Sistema Easyreg" />
  <meta property="og:description" content="" />
  <meta property="og:image" content="https://easyreg.net.br/img/logo_icon.png" />
  <!-- Twitter -->
  <meta property="twitter:card" content="summary_large_image" />
  <meta property="twitter:url" content="https://easyreg.net.br/" />
  <meta property="twitter:title" content="Sistema Easyreg" />
  <meta property="twitter:description" content="" />
  <meta property="twitter:image" content="https://easyreg.net.br/img/logo_icon.png" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <?= $this->Html->css(['css/adminlte', 'fontawesome-free/css/all.min.css', 'croppie']) ?>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css" rel="stylesheet" />

  
  <?= $this->fetch('css') ?>

  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <script src="/js/jquery.mask.js"></script>
  <script src="/chartjs/node_modules/chart.js/dist/chart.umd.js"></script>


</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php echo $this->element('top'); ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php echo $this->element('barra'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="container-fluid"><?= $this->Flash->render() ?></div>
      <?= $this->fetch('content') ?>
    </div>
    <!-- Main Footer -->
    <?php echo $this->element('rp'); ?>
  </div>
  <!-- ./wrapper -->
  


  <script>
    function ref(camporef) {
      var camporef;
      $('#camporef').val(camporef);
      $('.alert-success').hide();
      $('.alert-warning').hide();

    }

    $('.upload').on('click', function() {
      $('.alertas').html('<div class="alert alert-primary alert-dismissible fade show" role="alert"><strong><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando o arquivo...</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
      var file_data = $('#inputGroupFile04').prop('files')[0];
      var form_data = new FormData();
      var refield = $('#camporef').val();
      form_data.append('file', file_data);
      $.ajax({
        url: '/upload_top.php', // point to server-side PHP script 
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(php_script_response) {

          var retornomsg = php_script_response.trim();

          console.log(retornomsg);
          if (retornomsg == 'erro') {
            $('.alertas').html('<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Erro no upload do arquivo.</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          } else {
            $('#' + refield + '_alert').hide();
            $('#' + refield + '_sucesso').show();
            $('#' + refield).val(php_script_response.trim());
            $('#sv').text('Salvar Alteração');
            $('#inputGroupFile04').val('');
            $('.alertas').html('<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Upload realizado com sucesso!</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="alert alert-warning alert-dismissible fade show" role="alert"><strong>Salve o formulário para validar a alteração</strong> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            $('.alerta_salvar').html('<b>Antes de continuar, salve suas alterações!</b>');
          }
        }
      });
    });
  </script>


  <!-- jQuery UI 1.11.4 -->
  <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.min.js"></script>
  <!-- daterangepicker -->
  <script src="/plugins/moment/moment.min.js"></script>
  <script src="/plugins/daterangepicker/daterangepicker.js"></script>
  <script src="/js/croppie.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->

  <!-- overlayScrollbars -->
  <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/dist/js/adminlte.js"></script>
</body>
</html>