<!-- Sidebar -->
<!-- ... código anterior do sidebar ... -->
<?php $user = $this->Identity->get(); ?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <img class="img" src="<?= WWW; ?>/site/img/logos/favicon.png">
        </div>
        <div class="sidebar-brand-text mx-3">IA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <?php if ($user && $user->profile_id == 1): ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Plataforma
        </div>

        <!-- Apenas Admin vê o menu Sistema -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Sistema</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Engrebagem</h6>
                    <a class="collapse-item" href="/admin/users">Usuários</a>
                    <a class="collapse-item" href="/admin/profiles">Perfis</a>
                    <h6 class="collapse-header">Cadastros</h6>
                    <a class="collapse-item" href="/admin/projetos">Projetos</a>
                    <a class="collapse-item" href="/admin/atividades">Atividades</a>
                    <a class="collapse-item" href="/admin/inscricoes">Inscrições</a>

                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Cadastros</span>
            </a>
            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Cadastros de Alunos</h6>
                    <a class="collapse-item" href="/admin/alunos">Alunos</a>
                    <a class="collapse-item" href="/admin/escolaridades">Escolaridades</a>
                    <a class="collapse-item" href="/admin/enderecos">Endereços</a>
                </div>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAulas"
                aria-expanded="true" aria-controls="collapseAulas">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Aulas</span>
            </a>
            <div id="collapseAulas" class="collapse" aria-labelledby="headingAulas" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Área do Alunos</h6>
                    <a class="collapse-item" href="/admin/aulas">Aulas</a>
                    <a class="collapse-item" href="/admin/presencas">Presenças</a>
                </div>
            </div>
        </li>
    <?php endif; ?>
    <!-- Divider -->

    <hr class="sidebar-divider">
    <!-- Heading -->
    <?php if ($user && in_array($user->profile_id, [1, 2, 3])): ?>
        <div class="sidebar-heading">
            Site
        </div>
        <!-- Apenas Admin e coordenador vê o menu Sistema -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
                aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>Ações</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Site</h6>
                    <a class="collapse-item" href="/admin/categories">Categorias</a>
                    <a class="collapse-item" href="/admin/posts">Posts</a>
                    <a class="collapse-item" href="/admin/tags">Tags</a>
                    <div class="collapse-divider"></div>
                    <h6 class="collapse-header">Outros</h6>
                    <a class="collapse-item" href="/manutencao">Manutenção</a>

                </div>
            </div>
        </li>
    <?php endif; ?>
    <hr class="sidebar-divider">
    <?php if ($user && $user->profile_id == 1): ?>
        <div class="sidebar-heading">
            Outras Funções
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Charts</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-fw fa-table"></i>
                <span>Tables</span></a>
        </li>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
    <?php endif; ?>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->