<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <span id="unread-counter" class="badge badge-danger badge-counter">0</span>
            </a>
        
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts Center</h6>
                
                <div id="alerts-container">
                    </div>

                <a class="dropdown-item text-center small text-gray-500" href="/contacts">Ver todas as mensagens</a>
            </div>
        </li>

        <!-- Nav Item - Messages -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="https://titan.hostgator.com.br/login/" target="_blank">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter"></span>
            </a>
           
           
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php
                    $identity = $this->request->getAttribute('identity');
                    $primeiroNome = $identity ? explode(' ', $identity->name)[0] : 'Visitante';
                    ?><?= h($primeiroNome) ?>
                </span>
                <img class="img-profile rounded-circle" src="<?= $this->Url->assetUrl('dash/img/user-160x160.jpg') ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->

<script>
function refreshAlerts() {
    // Busca os dados da action que criamos no Controller
    fetch('<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Contacts', 'action' => 'checkNewMessages']) ?>')
        .then(response => response.json())
        .then(data => {
            // Atualiza o contador vermelho (Badge)
            const counter = document.getElementById('unread-counter');
            if (data.count > 0) {
                counter.style.display = 'inline';
                counter.innerText = data.count > 9 ? '9+' : data.count;
            } else {
                counter.style.display = 'none';
            }
            
            // Atualiza a lista dentro do dropdown
            const container = document.getElementById('alerts-container');
            container.innerHTML = ''; 

            if (data.messages.length === 0) {
                container.innerHTML = '<a class="dropdown-item text-center small text-gray-500">Nenhuma mensagem nova</a>';
            } else {
                data.messages.forEach(msg => {
                    // Formatamos a data vinda do campo 'created' da tua tabela
                    let msgDate = new Date(msg.created).toLocaleDateString('pt-PT');
                    
                    let itemHtml = `
                        <a class="dropdown-item d-flex align-items-center" href="contacts/view/${msg.id}">
                            <div class="mr-3">
                                <div class="icon-circle bg-primary">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${msgDate} - De: ${msg.name}</div>
                                <span class="font-weight-bold">${msg.subject}</span>
                            </div>
                        </a>
                    `;
                    container.innerHTML += itemHtml;
                });
            }
        })
        .catch(err => console.error("Erro ao carregar alertas:", err));
}

// Verifica novas mensagens a cada 30 segundos
setInterval(refreshAlerts, 30000);
// Carrega assim que a página abre
refreshAlerts();
</script>