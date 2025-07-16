<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Presenca> $presencas
 */
?>

<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/bg/bg-07.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1><?= __('Lista de Presenças') ?></h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="#!"><?= __('Presenças') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-style8">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4 class="h5 mb-0"><?= __('Presenças Registradas') ?></h4>
                        <?= $this->Html->link(__('Nova Presença'), ['action' => 'add'], ['class' => 'butn-style3 small']) ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col"><?= $this->Paginator->sort('id', __('ID')) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('aula_id', __('Aula')) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('aluno_id', __('Aluno')) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('presente', __('Presente')) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('created', __('Criado Em')) ?></th>
                                        <th scope="col"><?= $this->Paginator->sort('modified', __('Modificado Em')) ?></th>
                                        <th scope="col" class="actions"><?= __('Ações') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($presencas)) : ?>
                                        <?php foreach ($presencas as $presenca): ?>
                                            <tr>
                                                <td><?= $this->Number->format($presenca->id) ?></td>
                                                <td>
                                                    <?php
                                                    if ($presenca->hasValue('aula')) {
                                                        echo $this->Html->link($presenca->aula->id, ['controller' => 'Aulas', 'action' => 'view', $presenca->aula->id]);
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($presenca->hasValue('aluno')) {
                                                        echo $this->Html->link(
                                                            $presenca->aluno->nome_completo ?? 'Nome Desconhecido',
                                                            ['controller' => 'Alunos', 'action' => 'view', $presenca->aluno->id]
                                                        );
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </td>
                                                <td><?= $presenca->presente ? __('Sim') : __('Não') ?></td>
                                                <td><?= h($presenca->created->format('d/m/Y H:i:s')) ?></td>
                                                <td><?= h($presenca->modified->format('d/m/Y H:i:s')) ?></td>
                                                <td class="actions text-nowrap">
                                                    <?= $this->Html->link(__('Ver'), ['action' => 'view', $presenca->id], ['class' => 'btn btn-sm btn-info me-1']) ?>
                                                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $presenca->id], ['class' => 'btn btn-sm btn-warning me-1']) ?>
                                                    <?= $this->Form->postLink(
                                                        __('Deletar'),
                                                        ['action' => 'delete', $presenca->id],
                                                        [
                                                            'confirm' => __('Tem certeza que deseja deletar a presença # {0}?', $presenca->id),
                                                            'class' => 'btn btn-sm btn-danger'
                                                        ]
                                                    ) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                <?= __('Nenhuma presença encontrada.') ?>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="paginator mt-4 d-flex justify-content-between align-items-center flex-wrap">
                            <ul class="pagination pagination-sm mb-0">
                                <?= $this->Paginator->first('<< ' . __('Primeira'), ['class' => 'page-item']) ?>
                                <?= $this->Paginator->prev('< ' . __('Anterior'), ['class' => 'page-item']) ?>
                                <?= $this->Paginator->numbers(['class' => 'page-item', 'currentClass' => 'active', 'modulus' => 2]) ?>
                                <?= $this->Paginator->next(__('Próxima') . ' >', ['class' => 'page-item']) ?>
                                <?= $this->Paginator->last(__('Última') . ' >>', ['class' => 'page-item']) ?>
                            </ul>
                            <p class="mb-0 text-muted">
                                <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de {{count}} total')) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>