<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                
                                
                                
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Bem-vindo de volta!</h1>
                                </div>

                                <?= $this->Form->create() ?>
                                <div class="form-group">
                                    <?= $this->Form->control('email', [
                                        'label' => false,
                                        'placeholder' => 'Digite seu e-mail...',
                                        'class' => 'form-control form-control-user',
                                        'type' => 'email'
                                    ]) ?>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->control('password', [
                                        'label' => false,
                                        'placeholder' => 'Digite sua senha...',
                                        'class' => 'form-control form-control-user'
                                    ]) ?>
                                </div>
                                <?= $this->Flash->render() ?>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Lembrar-me</label>
                                    </div>
                                </div>
                                <?= $this->Form->button(__('Entrar'), ['class' => 'btn btn-primary btn-user btn-block']) ?>
                                <?= $this->Form->end() ?>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="#">Esqueceu a senha?</a>
                                </div>
                                <div class="text-center">
                                    <?= $this->Html->link(__('Criar uma conta!'), ['controller' => 'Users', 'action' => 'add'], ['class' => 'small']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>