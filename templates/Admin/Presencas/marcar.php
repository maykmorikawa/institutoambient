<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 * @var array $alunosInscritosConfirmados
 * @var array $presencasExistentes
 */
$this->assign('title', __('Marcar Frequência da Aula: {0} ({1})', $aula->data->format('d/m/Y'), $aula->atividade->nome));
?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0"><?= __('Marcar Frequência da Aula:') ?>
                    <small><?= $aula->data->format('d/m/Y') ?></small>
                </h3>
                <h5 class="mb-0 text-muted"><?= __('Atividade:') ?> <?= h($aula->atividade->nome) ?></h5>
            </div>
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'post']) ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('Matrícula') ?></th>
                                <th><?= __('Nome do Aluno') ?></th>
                                <th class="text-center"><?= __('Presente') ?></th>
                                <th class="actions"><?= __('Certificado') ?></th> <!-- Nova Coluna -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($alunosInscritosConfirmados)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        <?= __('Nenhum aluno inscrito e confirmado para esta atividade.') ?></td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($alunosInscritosConfirmados as $inscricao): ?>
                                    <?php $aluno = $inscricao->aluno; ?>
                                    <tr>
                                        <td><?= h($aluno->id) ?></td>
                                        <td><?= h($aluno->nome_completo) ?></td>
                                        <td class="text-center">
                                            <?php
                                            $isChecked = false;
                                            if (isset($presencasExistentes[$aluno->id])) {
                                                $isChecked = (bool) $presencasExistentes[$aluno->id]->presente;
                                            }
                                            echo $this->Form->checkbox("presenca[{$aluno->id}]", [
                                                'value' => 1,
                                                'checked' => $isChecked,
                                                'label' => false,
                                                'class' => 'form-check-input',
                                            ]);
                                            ?>
                                        </td>
                                        <td class="actions text-center">
                                            <?= $this->Html->link(
                                                '<i class="bi bi-file-earmark-pdf-fill"></i> ' . __('Gerar'),
                                                ['controller' => 'Certificados', 'action' => 'gerar', $aluno->id, $aula->atividade->id],
                                                // A OPÇÃO 'target' => '_blank' FOI REMOVIDA DA LINHA ABAIXO
                                                ['class' => 'btn btn-sm btn-primary', 'escape' => false]
                                            ) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <?= $this->Html->link(
                        '<i class="bi bi-arrow-left-square-fill"></i> ' . __('Voltar para Atividade'),
                        ['controller' => 'Atividades', 'action' => 'view', $aula->atividade->id],
                        ['class' => 'btn btn-info', 'escape' => false]
                    ) ?>
                    <?= $this->Form->button('<i class="bi bi-save"></i> ' . __('Salvar Frequência'), ['class' => 'btn btn-success', 'escape' => false]) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>