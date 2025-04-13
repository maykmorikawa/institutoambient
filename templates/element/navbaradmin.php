    <!-- Sidebar -->
    <nav class="bg-dark text-white p-3" style="min-width: 200px; height: 100vh;">
        <h5>Painel Admin</h5>
        <ul class="nav flex-column">
            <li class="nav-item"><a class="nav-link text-white" href="<?= $this->Url->build('/admin/posts') ?>">Posts</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?= $this->Url->build('/admin/categories') ?>">Categorias</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?= $this->Url->build('/admin/users') ?>">Usuários</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="<?= $this->Url->build('/') ?>">Voltar ao site</a></li>
        </ul>
    </nav>