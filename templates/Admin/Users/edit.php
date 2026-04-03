<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $profiles
 */
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4 border-left-info">
            <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center border-bottom-info">
                <h6 class="m-0 font-weight-bold text-info">
                    <i class="fas fa-user-edit me-2"></i><?= __('Editar Usuário') ?>: <span class="text-dark"><?= h($user->name) ?></span>
                </h6>
                <div class="btn-group">
                    <?= $this->Html->link('<i class="fas fa-arrow-left me-1"></i> Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary shadow-sm', 'escape' => false]) ?>
                    <?php if (!$user->isNew()): ?>
                        <?= $this->Form->postLink(
                            '<i class="fas fa-trash me-1"></i> Excluir',
                            ['action' => 'delete', $user->id],
                            [
                                'confirm' => __('Deseja realmente excluir o usuário "{0}" e tudo a ele vinculado?', $user->name),
                                'class' => 'btn btn-sm btn-danger shadow-sm ms-2',
                                'escape' => false
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body py-4">
                <?= $this->Form->create($user, ['class' => 'user']) ?>
                
                <h6 class="heading-small text-muted mb-4 border-bottom pb-2">Informações Pessoais</h6>
                
                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Nome Completo') ?></label>
                        <?= $this->Form->control('name', [
                            'label' => false,
                            'class' => 'form-control border-left-info shadow-sm'
                        ]) ?>
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('E-mail') ?></label>
                        <?= $this->Form->control('email', [
                            'label' => false,
                            'class' => 'form-control shadow-sm'
                        ]) ?>
                    </div>
                </div>

                <h6 class="heading-small text-muted mb-4 mt-2 border-bottom pb-2">Acesso e Segurança</h6>

                <div class="row">
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase"><?= __('Perfil de Acesso') ?></label>
                        <?= $this->Form->control('profile_id', [
                            'label' => false,
                            'options' => $profiles,
                            'empty' => 'Selecione um perfil...',
                            'class' => 'form-control custom-select shadow-sm'
                        ]) ?>
                    </div>
                    
                    <div class="col-md-6 form-group mb-4">
                        <label class="font-weight-bold text-dark small text-uppercase">
                            <?= __('Senha') ?> <span class="badge badge-warning fw-normal ms-1">Mudar senha</span>
                        </label>
                        <?= $this->Form->control('password', [
                            'label' => false,
                            'class' => 'form-control shadow-sm',
                            'placeholder' => 'Apenas se quiser alterar...',
                            'value' => '', // ⚠️ Deixa o campo vazio
                            'required' => false // Opcionalmente não obrigatório
                        ]) ?>
                        <small class="form-text text-muted">Deixe em branco se não desejar alterar a senha atual do usuário.</small>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-info btn-icon-split shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text font-weight-bold px-4"><?= __('Atualizar Usuário') ?></span>
                    </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
