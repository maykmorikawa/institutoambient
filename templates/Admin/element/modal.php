<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?= __('Deseja sair?') ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"><?= __('Selecione "Sair" abaixo se você estiver pronto para encerrar sua sessão atual.') ?></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><?= __('Cancelar') ?></button>
                    <a class="btn btn-primary" href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'logout']) ?>"><?= __('Sair') ?></a>
                </div>
            </div>
        </div>
    </div>