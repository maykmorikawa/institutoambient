<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Profile> $profiles
 */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= __('Perfis') ?></h6>
        <?= $this->Html->link(__('Novo Perfil'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('name', 'Nome') ?></th>
                        <th class="actions"><?= __('Ações') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($profiles as $profile): ?>
                    <tr>
                        <td><?= $this->Number->format($profile->id) ?></td>
                        <td><?= h($profile->name) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Ver'), ['action' => 'view', $profile->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                            <?= $this->Html->link(__('Editar'), ['action' => 'edit', $profile->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?= $this->Form->postLink(
                                __('Apagar'),
                                ['action' => 'delete', $profile->id],
                                [
                                    'confirm' => __('Tem certeza que deseja apagar o perfil # {0}?', $profile->id),
                                    'class' => 'btn btn-sm btn-outline-danger'
                                ]
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator mt-3">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('primeiro'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->prev('< ' . __('anterior'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->numbers(['class' => 'page-link']) ?>
                <?= $this->Paginator->next(__('próximo') . ' >', ['class' => 'page-link']) ?>
                <?= $this->Paginator->last(__('último') . ' >>', ['class' => 'page-link']) ?>
            </ul>
            <p class="text-center">
                <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} no total')) ?>
            </p>
        </div>
    </div>
</div>