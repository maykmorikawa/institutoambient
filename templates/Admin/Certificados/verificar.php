<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Certificado $certificado
 */
$this->assign('title', __('Verificação de Certificado'));
?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card mt-5">
            <div class="card-header">
                <h3 class="mb-0"><?= __('Verificação de Certificado') ?></h3>
            </div>
            <div class="card-body">
                <?php if (!empty($certificado)): ?>
                    <p class="lead text-success"><?= __('Certificado encontrado e válido!') ?></p>
                    <table class="table table-bordered">
                        <tr>
                            <th><?= __('Código de Autenticação') ?></th>
                            <td><?= h($certificado->codigo_autenticacao) ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Aluno') ?></th>
                            <td><?= h($certificado->aluno->nome_completo ?? 'N/A') ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Atividade') ?></th>
                            <td><?= h($certificado->atividade->nome ?? 'N/A') ?></td>
                        </tr>
                        <tr>
                            <th><?= __('Carga Horária') ?></th>
                            <td><?= h($certificado->carga_horaria_total) ?> horas</td>
                        </tr>
                        <tr>
                            <th><?= __('Data de Emissão') ?></th>
                            <td><?= $certificado->data_emissao ? $certificado->data_emissao->format('d/m/Y') : 'N/A' ?></td>
                        </tr>
                    </table>
                    <p class="text-muted mt-3"><?= __('Este certificado foi emitido em conformidade com as informações registradas em nosso sistema.') ?></p>
                <?php else: ?>
                    <p class="lead text-danger"><?= __('Certificado não encontrado ou código inválido.') ?></p>
                    <p class="text-muted"><?= __('Por favor, verifique o código de autenticação e tente novamente.') ?></p>
                <?php endif; ?>
                <div class="mt-4">
                    <?= $this->Html->link(
                        '<i class="bi bi-house-fill"></i> ' . __('Voltar para a Página Inicial'),
                        ['controller' => 'Pages', 'action' => 'display', 'home'],
                        ['class' => 'btn btn-primary', 'escape' => false]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
</div>