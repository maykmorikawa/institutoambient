<?php
/**
 * Admin Layout
 *
 * @var \App\View\AppView $this
 */
$cakeDescription = 'Instituto Ambient - Admin';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <?= $this->Html->charset() ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?= $cakeDescription ?>:
    <?= $this->fetch('title') ?>
  </title>
  <?= $this->Html->meta('icon') ?>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <?= $this->Html->css(['admin_modern']) ?>

  <?= $this->fetch('meta') ?>
  <?= $this->fetch('css') ?>
  <?= $this->fetch('script') ?>
</head>

<body id="page-top">

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->Url->build('/') ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-leaf"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Instituto Ambient</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= $this->request->getParam('controller') == 'Pages' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'home']) ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Gestão
      </div>

      <li class="nav-item <?= $this->request->getParam('controller') == 'Inscricoes' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Inscricoes', 'action' => 'index']) ?>">
          <i class="fas fa-fw fa-file-signature"></i>
          <span>Inscrições</span>
        </a>
      </li>

      <li class="nav-item <?= $this->request->getParam('controller') == 'Alunos' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Alunos', 'action' => 'index']) ?>">
          <i class="fas fa-fw fa-user-graduate"></i>
          <span>Alunos</span>
        </a>
      </li>

      <li class="nav-item <?= $this->request->getParam('controller') == 'Atividades' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Atividades', 'action' => 'index']) ?>">
          <i class="fas fa-fw fa-calendar-alt"></i>
          <span>Atividades</span>
        </a>
      </li>

      <li class="nav-item <?= $this->request->getParam('controller') == 'Users' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>">
          <i class="fas fa-fw fa-users"></i>
          <span>Usuários</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <div class="sidebar-heading">
        Configurações
      </div>

      <li class="nav-item <?= $this->request->getParam('controller') == 'Settings' ? 'active' : '' ?>">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Settings', 'action' => 'index']) ?>">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Sistema</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Sair</span>
        </a>
      </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar topbar">


          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto" style="display:flex; list-style:none; align-items:center; gap:20px;">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?= $this->request->getAttribute('identity') ? $this->request->getAttribute('identity')->get('email') : 'Admin' ?>
                </span>
                <div class="img-profile"
                  style="background-color: #ddd; display:flex; align-items:center; justify-content:center;">
                  <i class="fas fa-user"></i>
                </div>
              </a>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <?= $this->Flash->render() ?>

          <?= $this->fetch('content') ?>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white"
        style="padding: 2rem 0; text-align: center; color: #aaa; font-size: 0.8rem;">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Instituto Ambient <?= date('Y') ?></span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top"
    style="position:fixed; bottom:20px; right:20px; background:var(--primary-color); color:white; width:40px; height:40px; text-align:center; line-height:40px; border-radius:50%; display:none;">
    <i class="fas fa-angle-up"></i>
  </a>

  <script>
    // Simple script to toggle sidebar if needed, though hidden on mobile by default css
  </script>

</body>

</html>