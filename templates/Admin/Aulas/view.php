<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 */
?>
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-4 mb-lg-0">
                <div class="card card-style8">
                    <div class="card-header bg-primary text-white">
                        <h4 class="h5 mb-0"><?= __('Ações') ?></h4>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <?= $this->Html->link(__('Editar Aula'), ['action' => 'edit', $aula->id], ['class' => 'd-block text-decoration-none']) ?>
                            </li>
                            <li class="mb-2">
                                <?= $this->Form->postLink(__('Deletar Aula'), ['action' => 'delete', $aula->id], ['confirm' => __('Tem certeza que deseja deletar a aula # {0}?', $aula->id), 'class' => 'd-block text-decoration-none text-danger']) ?>
                            </li>
                            <li class="mb-2">
                                <?= $this->Html->link(__('Listar Aulas'), ['action' => 'index'], ['class' => 'd-block text-decoration-none']) ?>
                            </li>
                            <li>
                                <?= $this->Html->link(__('Nova Aula'), ['action' => 'add'], ['class' => 'd-block text-decoration-none']) ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="alunos form content">
                    <h2 class="h3 mb-4">Aula #<?= h($aula->id) ?></h2>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Detalhes Principais</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-borderless mb-0">
                                <tr>
                                    <th scope="row" class="w-25"><?= __('Atividade') ?></th>
                                    <td><?= $aula->hasValue('atividade') ? $this->Html->link($aula->atividade->nome, ['controller' => 'Atividades', 'action' => 'view', $aula->atividade->id]) : 'N/A' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= __('ID da Aula') ?></th>
                                    <td><?= $this->Number->format($aula->id) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= __('Data') ?></th>
                                    <td><?= h($aula->data->format('d/m/Y')) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= __('Criado Em') ?></th>
                                    <td><?= h($aula->created->format('d/m/Y H:i:s')) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= __('Última Modificação') ?></th>
                                    <td><?= h($aula->modified->format('d/m/Y H:i:s')) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?= __('Conteúdo da Aula') ?></h5>
                        </div>
                        <div class="card-body">
                            <?= $this->Text->autoParagraph(h($aula->conteudo)); ?>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?= __('Observações') ?></h5>
                        </div>
                        <div class="card-body">
                            <?= $this->Text->autoParagraph(h($aula->observacoes)); ?>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><?= __('Presenças Relacionadas') ?></h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($aula->presencas)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col"><?= __('ID') ?></th>
                                                <th scope="col"><?= __('ID da Aula') ?></th>
                                                <th scope="col"><?= __('ID do Aluno') ?></th>
                                                <th scope="col"><?= __('Presente') ?></th>
                                                <th scope="col"><?= __('Observações') ?></th>
                                                <th scope="col"><?= __('Criado Em') ?></th>
                                                <th scope="col"><?= __('Modificado Em') ?></th>
                                                <th scope="col" class="actions"><?= __('Ações') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($aula->presencas as $presenca): ?>
                                                <tr>
                                                    <td><?= h($presenca->id) ?></td>
                                                    <td><?= h($presenca->aula_id) ?></td>
                                                    <td><?= $this->Html->link($presenca->aluno_id, ['controller' => 'Alunos', 'action' => 'view', $presenca->aluno_id]) ?>
                                                    </td>
                                                    <td><?= $presenca->presente ? __('Sim') : __('Não') ?></td>
                                                    <td><?= h($presenca->observacoes) ?></td>
                                                    <td><?= h($presenca->created) ?></td>
                                                    <td><?= h($presenca->modified) ?></td>
                                                    <td class="actions">
                                                        <?= $this->Html->link(__('Ver'), ['controller' => 'Presencas', 'action' => 'view', $presenca->id], ['class' => 'btn btn-sm btn-info me-1']) ?>
                                                        <?= $this->Html->link(__('Editar'), ['controller' => 'Presencas', 'action' => 'edit', $presenca->id], ['class' => 'btn btn-sm btn-warning me-1']) ?>
                                                        <?= $this->Form->postLink(
                                                            __('Deletar'),
                                                            ['controller' => 'Presencas', 'action' => 'delete', $presenca->id],
                                                            [
                                                                'confirm' => __('Tem certeza que deseja deletar # {0}?', $presenca->id),
                                                                'class' => 'btn btn-sm btn-danger'
                                                            ]
                                                        ) ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="alert alert-info mb-0">
                                    <?= __('Nenhuma presença relacionada encontrada para esta aula.') ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>