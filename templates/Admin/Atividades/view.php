<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 */
?>
<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= h($atividade->nome) ?></h3>
                <div>
                    <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['action' => 'edit', $atividade->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false, 'style' => 'margin-right: 10px;']) ?>
                    <?= $this->Form->postLink(
                        '<i class="bi bi-trash-fill"></i> ' . __('Excluir'),
                        ['action' => 'delete', $atividade->id],
                        ['confirm' => __('Tem certeza que deseja excluir a atividade #{0}?', $atividade->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]
                    ) ?>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th><?= __('Projeto') ?></th>
                        <td><?= $atividade->hasValue('projeto') ? $this->Html->link($atividade->projeto->name, ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Projeto') . '</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Nome') ?></th>
                        <td><?= h($atividade->nome) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Local') ?></th>
                        <td><?= h($atividade->local) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Dias Semana') ?></th>
                        <td><?= h($atividade->dias_semana) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Usuário') ?></th>
                        <td><?= $atividade->hasValue('user') ? $this->Html->link($atividade->user->name, ['controller' => 'Users', 'action' => 'view', $atividade->user->id]) : '<span class="badge bg-secondary text-white">' . __('Sem Usuário') . '</span>' ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('Slug') ?></th>
                        <td><?= h($atividade->slug) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Link Inscrição') ?></th>
                        <td>
                            <span id="link-inscricao"><?= h($atividade->link_inscricao) ?></span>
                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copiarLink()">Copiar</button>
                        </td>
                    </tr>
                    <tr>
                        <th><?= __('ID') ?></th>
                        <td><?= $this->Number->format($atividade->id) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Vagas') ?></th>
                        <td><?= $this->Number->format($atividade->vagas) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Horário') ?></th>
                        <td><?= h($atividade->horario) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Criado em') ?></th>
                        <td><?= $atividade->created ? $atividade->created->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modificado em') ?></th>
                        <td><?= $atividade->modified ? $atividade->modified->format('d/m/Y H:i') : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Publicado') ?></th>
                        <td><?= $atividade->publicado ? '<span class="badge bg-success text-white">Sim</span>' : '<span class="badge bg-danger text-white">Não</span>' ?>
                        </td>
                    </tr>
                </table>
                <div class="text mt-3">
                    <strong><?= __('Descrição') ?></strong>
                    <blockquote>
                        <?= $this->Text->autoParagraph(h($atividade->descricao)); ?>
                    </blockquote>
                </div>
            </div>
        </div>

        <div class="related mt-4">
            <h4><?= __('Aulas Relacionadas') ?></h4>
            <?php if (!empty($atividade->aulas)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Atividade ID') ?></th>
                                <th><?= __('Data') ?></th>
                                <th><?= __('Conteúdo') ?></th>
                                <th><?= __('Observações') ?></th>
                                <th><?= __('Criado em') ?></th>
                                <th><?= __('Modificado em') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($atividade->aulas as $aula): ?>
                                <tr>
                                    <td><?= h($aula->id) ?></td>
                                    <td><?= h($aula->atividade_id) ?></td>
                                    <td><?= $aula->data ? $aula->data->format('d/m/Y') : '-' ?></td>
                                    <td><?= h($aula->conteudo) ?></td>
                                    <td><?= h($aula->observacoes) ?></td>
                                    <td><?= $aula->created ? $aula->created->format('d/m/Y H:i') : '-' ?></td>
                                    <td><?= $aula->modified ? $aula->modified->format('d/m/Y H:i') : '-' ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Aulas', 'action' => 'view', $aula->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Aulas', 'action' => 'edit', $aula->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Aulas', 'action' => 'delete', $aula->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $aula->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="related mt-4">
            <h4><?= __('Inscrições Relacionadas') ?></h4>
            <?php if (!empty($atividade->inscricoes)): ?>
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
                            <?php foreach ($atividade->inscricoes as $inscrico): ?>
                                <tr>
                                    <td><?= h($inscrico->id) ?></td>
                                    <td><?= h($inscrico->aluno_id) ?></td>
                                    <td><?= h($inscrico->atividade_id) ?></td>
                                    <td><?= h($inscrico->user_id) ?></td>
                                    <td><?= h($inscrico->responsavel_id) ?></td>
                                    <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y') : '-' ?></td>
                                    <td><?= h($inscrico->status) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscrico->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscrico->id], ['confirm' => __('Tem certeza que deseja excluir # {0}?', $inscrico->id), 'class' => 'btn btn-sm btn-outline-danger', 'escape' => false]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <div class="mt-3">
            <?= $this->Html->link('<i class="bi bi-arrow-left-square-fill"></i> ' . __('Listar Atividades'), ['action' => 'index'], ['class' => 'btn btn-info', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="bi bi-plus-square-fill"></i> ' . __('Nova Atividade'), ['action' => 'add'], ['class' => 'btn btn-success', 'escape' => false, 'style' => 'margin-left: 10px;']) ?>
        </div>
    </div>
</div>


<!-- Script para copiar -->
<script>
    function copiarLink() {
        let texto = document.getElementById('link-inscricao').textContent;

        // Remove "/admin" se estiver no link
        texto = texto.replace('/admin/', '/');

        navigator.clipboard.writeText(texto).then(function () {
            alert("Link copiado com sucesso!");
        }, function (err) {
            alert("Erro ao copiar link: " + err);
        });
    }
</script>