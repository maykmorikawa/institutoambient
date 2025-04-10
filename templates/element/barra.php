<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #44161F;">
  <!-- Brand Logo -->
  <a href="/?" class="brand-link">
    <img src="/img/logo.png" alt="Sistema Easyreg" style="width: 100%;">
  </a>
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <?php $nome = explode(' ', USUARIO); ?>
        <a href="/" class="d-block"><?= $nome[0] . " " . end($nome);   ?></a>

      </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if (PERFIL == 1) {  ?>
          <!-- -------------------------------------------------------------------------------------   
            USUÁRIOS
            -------------------------------------------------------------------------------------   -->
          <li class="nav-item">
            <a href="/Users/Dashboard" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                <!-- -------------------------------------------------------------------------------------   -->
                DASHBOARD
                <!-- -------------------------------------------------------------------------------------   -->
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                <!-- -------------------------------------------------------------------------------------   -->
                USUÁRIOS
                <!-- -------------------------------------------------------------------------------------   -->
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/profiles" class="nav-link">
                  <i class="fas fa-user"></i>
                  <p> Perfis</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/users" class="nav-link ">
                  <i class="fas fa-users"></i>
                  <p> Usuários do sistema</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/listfuncionarios" class="nav-link ">
                  <i class="fas fa-users"></i>
                  <p>Funcionário</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/listcolaboardores" class="nav-link ">
                  <i class="fas fa-users"></i>
                  <p>Colaboradores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/Users/Dashboard" class="nav-link ">
                  <i class="fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
            </ul>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                <!-- -------------------------------------------------------------------------------------   -->
                CONTEÚDO
                <!-- -------------------------------------------------------------------------------------   -->
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/typemodules" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>INSTITUIÇÕES / SETOR</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/schoolings" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>EETEPA</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/typeusers" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>TIPO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/jobs" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>CARGO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/indications" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>INDICAÇÃO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/polls" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>LOCAL DE VOTAÇÃO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/neighborhoods" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>BAIRRO</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/cities" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>CIDADE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/states" class="nav-link">
                  <i class="fas fa-table"></i>
                  <p>ESTADO</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book-open"></i>
              <p>
                <!-- -------------------------------------------------------------------------------------   -->
                POR BAIRRO
                <!-- -------------------------------------------------------------------------------------   -->
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <?php foreach ($bairros as $bairro) : ?>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/neighborhoods/view/<?= $bairro->id ?>" class="nav-link">
                    <i class="fas fa-table"></i>
                    <p><?= $bairro->title ?></p>
                  </a>
                </li>
              </ul>
            <?php endforeach; ?>
          </li>
        <?php } ?>
        <?php if (PERFIL == 6 or PERFIL == 1) {  ?>
          <li class="nav-item">
            <a href="/users/add" class="nav-link">
              <i class="fas fa-users"></i>
              <p>
                <!-- -------------------------------------------------------------------------------------   -->
                CADASTRO
                <!-- -------------------------------------------------------------------------------------   -->
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
      </ul>
    <?php } ?>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>