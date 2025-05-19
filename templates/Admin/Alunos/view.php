<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 */
?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= h($aluno->nome_completo) ?></h3>
                <div>
                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                        ['action' => 'delete', $aluno->id],
                        ['confirm' => __('Tem certeza que deseja excluir o aluno #{0}?', $aluno->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]
                    ) ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><?= __('Usuário') ?></th>
                        <td><?= $aluno->hasValue('user') ? $this->Html->link($aluno->user->name, ['controller' => 'Users', 'action' => 'view', $aluno->user->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Nome Completo') ?></th>
                        <td><?= h($aluno->nome_completo) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td><?= h($aluno->email) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('CPF') ?></th>
                        <td><?= h($aluno->cpf) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('RG') ?></th>
                        <td><?= h($aluno->rg) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('NIS') ?></th>
                        <td><?= h($aluno->nis) ?></td>
                    </tr>
                     <tr>
                        <th><?= __('Telefone') ?></th>
                        <td><?= h($aluno->telefone) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><?= $this->Number->format($aluno->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Data de Nascimento') ?></th>
                        <td><?= $aluno->data_nascimento ? $aluno->data_nascimento->format('d/m/Y') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Criado') ?></th>
                        <td><?= $aluno->created ? $aluno->created->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modificado') ?></th>
                        <td><?= $aluno->modified ? $aluno->modified->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-start">
                 <?= $this->Html->link('<i class="bi bi-arrow-left-square-fill"></i> ' . __('Listar Alunos'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                <?= $this->Html->link('<i class="bi bi-person-plus-fill"></i> ' . __('Novo Aluno'), ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false]) ?>
            </div>
        </div>

           <div class="card mt-4">
            <div class="card-header">
                <h4><?= __('Endereços Relacionados') ?></h4>
            </div>
            <div class="card-body">
                <?php if (!empty($aluno->enderecos)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Aluno ID') ?></th>
                                <th><?= __('CEP') ?></th>
                                <th><?= __('Logradouro') ?></th>
                                <th><?= __('Número') ?></th>
                                <th><?= __('Complemento') ?></th>
                                <th><?= __('Bairro') ?></th>
                                <th><?= __('Cidade') ?></th>
                                <th><?= __('Estado') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aluno->enderecos as $endereco) : ?>
                            <tr>
                                <td><?= h($endereco->id) ?></td>
                                <td><?= h($endereco->aluno_id) ?></td>
                                <td><?= h($endereco->cep) ?></td>
                                <td><?= h($endereco->logradouro) ?></td>
                                <td><?= h($endereco->numero) ?></td>
                                <td><?= h($endereco->complemento) ?></td>
                                <td><?= h($endereco->bairro) ?></td>
                                <td><?= h($endereco->cidade) ?></td>
                                <td><?= h($endereco->estado) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Enderecos', 'action' => 'view', $endereco->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Enderecos', 'action' => 'edit', $endereco->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Enderecos', 'action' => 'delete', $endereco->id], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => __('Tem certeza que deseja excluir o endereço #{0}?', $endereco->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4><?= __('Escolaridades Relacionadas') ?></h4>
            </div>
            <div class="card-body">
                <?php if (!empty($aluno->escolaridades)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                 <th><?= __('ID') ?></th>
                                <th><?= __('Aluno ID') ?></th>
                                <th><?= __('Nível') ?></th>
                                <th><?= __('Série') ?></th>
                                <th><?= __('Situação') ?></th>
                                <th><?= __('Curso') ?></th>
                                <th><?= __('Instituição') ?></th>
                                <th><?= __('Ano Conclusão') ?></th>
                                <th><?= __('Criado') ?></th>
                                <th><?= __('Modificado') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aluno->escolaridades as $escolaridade) : ?>
                            <tr>
                                <td><?= h($escolaridade->id) ?></td>
                                <td><?= h($escolaridade->aluno_id) ?></td>
                                <td><?= h($escolaridade->nivel) ?></td>
                                <td><?= h($escolaridade->serie) ?></td>
                                <td><?= h($escolaridade->situacao) ?></td>
                                <td><?= h($escolaridade->curso) ?></td>
                                <td><?= h($escolaridade->instituicao) ?></td>
                                <td><?= h($escolaridade->ano_conclusao) ?></td>
                                 <td><?= $escolaridade->created ? $escolaridade->created->format('d/m/Y H:i') : '-' ?></td>
                                <td><?= $escolaridade->modified ? $escolaridade->modified->format('d/m/Y H:i') : '-' ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Escolaridades', 'action' => 'view', $escolaridade->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Escolaridades', 'action' => 'edit', $escolaridade->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Escolaridades', 'action' => 'delete', $escolaridade->id], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => __('Tem certeza que deseja excluir a escolaridade #{0}?', $escolaridade->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4><?= __('Inscrições Relacionadas') ?></h4>
            </div>
            <div class="card-body">
                <?php if (!empty($aluno->inscricoes)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Aluno ID') ?></th>
                                <th><?= __('Atividade ID') ?></th>
                                <th><?= __('Usuário ID') ?></th>
                                <th><?= __('Responsável ID') ?></th>
                                <th><?= __('Data Inscrição') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aluno->inscricoes as $inscrico) : ?>
                            <tr>
                                <td><?= h($inscrico->id) ?></td>
                                <td><?= h($inscrico->aluno_id) ?></td>
                                <td><?= h($inscrico->atividade_id) ?></td>
                                <td><?= h($inscrico->user_id) ?></td>
                                <td><?= h($inscrico->responsavel_id) ?></td>
                                <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?></td>
                                <td><?= h($inscrico->status) ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscrico->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscrico->id], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => __('Tem certeza que deseja excluir a inscrição #{0}?', $inscrico->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h4><?= __('Presenças Relacionadas') ?></h4>
            </div>
            <div class="card-body">
                <?php if (!empty($aluno->presencas)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Aula ID') ?></th>
                                <th><?= __('Aluno ID') ?></th>
                                <th><?= __('Presente') ?></th>
                                <th><?= __('Observações') ?></th>
                                <th><?= __('Criado') ?></th>
                                <th><?= __('Modificado') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aluno->presencas as $presenca) : ?>
                            <tr>
                                <td><?= h($presenca->id) ?></td>
                                <td><?= h($presenca->aula_id) ?></td>
                                <td><?= h($presenca->aluno_id) ?></td>
                                <td><?= h($presenca->presente) ?></td>
                                <td><?= h($presenca->observacoes) ?></td>
                                 <td><?= $presenca->created ? $presenca->created->format('d/m/Y H:i') : '-' ?></td>
                                <td><?= $presenca->modified ? $presenca->modified->format('d/m/Y H:i') : '-' ?></td>
                                <td class="actions">
                                    <?= $this->Html->link(__('Ver'), ['controller' => 'Presencas', 'action' => 'view', $presenca->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= $this->Html->link(__('Editar'), ['controller' => 'Presencas', 'action' => 'edit', $presenca->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                                    <?= $this->Form->postLink(__('Excluir'), ['controller' => 'Presencas', 'action' => 'delete', $presenca->id], ['class' => 'btn btn-sm btn-outline-danger', 'confirm' => __('Tem certeza que deseja excluir a presença #{0}?', $presenca->id)]) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>