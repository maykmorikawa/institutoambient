<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $this->Url->build('/'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <?= $this->Html->image('site/img/logos/favicon.png', ['class' => 'img', 'alt' => 'Logo']); ?>
        </div>
        <div class="sidebar-brand-text mx-3">IA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?= $this->Url->build('/admin'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Components -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseComponents" aria-expanded="false" aria-controls="collapseComponents">
            <i class="fas fa-fw fa-cog"></i>
            <span>Components</span>
        </a>
        <div id="collapseComponents" class="collapse" aria-labelledby="headingComponents" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Components:</h6>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/buttons'); ?>">Buttons</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/cards'); ?>">Cards</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUtilities" aria-expanded="false" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Custom Utilities:</h6>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/utilities-color'); ?>">Colors</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/utilities-border'); ?>">Borders</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/utilities-animation'); ?>">Animations</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/utilities-other'); ?>">Other</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>

    <!-- Nav Item - Pages -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Paginas</h6>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/users'); ?>">Users</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/posts'); ?>">Posts</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/tags'); ?>">Tags</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/404'); ?>">404 Page</a>
                <a class="collapse-item" href="<?= $this->Url->build('/admin/blank'); ?>">Blank Page</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build('/admin/charts'); ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span>
        </a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->Url->build('/admin/tables'); ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Tables</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
