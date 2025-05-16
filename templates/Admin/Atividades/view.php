<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= h($atividade->titulo) ?></h2>
        <div>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Editar', ['action' => 'edit', $atividade->id], ['class' => 'btn btn-outline-secondary me-2', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="bi bi-trash"></i> Excluir', ['action' => 'delete', $atividade->id], [
                'class' => 'btn btn-outline-danger',
                'escape' => false,
                'confirm' => __('Tem certeza que deseja excluir a atividade #{0}?', $atividade->id),
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold"><?= __('Detalhes da Atividade') ?></div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th><?= __('Projeto') ?></th>
                    <td><?= $atividade->hasValue('projeto') ? $this->Html->link($atividade->projeto->titulo, ['controller' => 'Projetos', 'action' => 'view', $atividade->projeto->id]) : '-' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Título') ?></th>
                    <td><?= h($atividade->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($atividade->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Link Inscrição') ?></th>
                    <td>
                        <div class="input-group">
                            <input type="text" id="linkInscricao" class="form-control"
                                value="<?= $this->Url->build('/inscricao/' . $atividade->link_inscricao, ['fullBase' => true]) ?>"
                                readonly>
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="copiarLink()">Copiar</button>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($atividade->id) ?></td>
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
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold"><?= __('Descrição') ?></div>
        <div class="card-body">
            <blockquote>
                <?= $this->Text->autoParagraph(h($atividade->descricao)); ?>
            </blockquote>
        </div>
    </div>

    <?php if (!empty($atividade->alunos)): ?>
        <div class="card mb-4">
            <div class="card-header fw-bold"><?= __('Alunos Relacionados') ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Nome') ?></th>
                                <th><?= __('Email') ?></th>
                                <th><?= __('CPF') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($atividade->alunos as $aluno): ?>
                                <tr>
                                    <td><?= h($aluno->id) ?></td>
                                    <td><?= h($aluno->nome) ?></td>
                                    <td><?= h($aluno->email) ?></td>
                                    <td><?= h($aluno->cpf) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Alunos', 'action' => 'view', $aluno->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Alunos', 'action' => 'edit', $aluno->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Alunos', 'action' => 'delete', $aluno->id], [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'escape' => false,
                                            'confirm' => __('Tem certeza que deseja excluir o aluno #{0}?', $aluno->id),
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($atividade->inscricoes)): ?>
        <div class="card mb-4">
            <div class="card-header fw-bold"><?= __('Inscrições Relacionadas') ?></div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th><?= __('ID') ?></th>
                                <th><?= __('Aluno') ?></th>
                                <th><?= __('Data Inscrição') ?></th>
                                <th><?= __('Status') ?></th>
                                <th class="actions"><?= __('Ações') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($atividade->inscricoes as $inscrico): ?>
                                <tr>
                                    <td><?= h($inscrico->id) ?></td>
                                    <td><?= $inscrico->hasValue('aluno') ? $this->Html->link($inscrico->aluno->nome, ['controller' => 'Alunos', 'action' => 'view', $inscrico->aluno->id]) : '-' ?>
                                    </td>
                                    <td><?= $inscrico->data_inscricao ? $inscrico->data_inscricao->format('d/m/Y H:i') : '-' ?>
                                    </td>
                                    <td><?= h($inscrico->status) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link('<i class="bi bi-eye-fill"></i> ' . __('Ver'), ['controller' => 'Inscricoes', 'action' => 'view', $inscrico->id], ['class' => 'btn btn-sm btn-outline-primary', 'escape' => false]) ?>
                                        <?= $this->Html->link('<i class="bi bi-pencil-square"></i> ' . __('Editar'), ['controller' => 'Inscricoes', 'action' => 'edit', $inscrico->id], ['class' => 'btn btn-sm btn-outline-secondary', 'escape' => false]) ?>
                                        <?= $this->Form->postLink('<i class="bi bi-trash-fill"></i> ' . __('Excluir'), ['controller' => 'Inscricoes', 'action' => 'delete', $inscrico->id], [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'escape' => false,
                                            'confirm' => __('Tem certeza que deseja excluir a inscrição #{0}?', $inscrico->id),
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<?php $this->Html->scriptStart(['block' => true]); ?>
<script>
    function copiarLink() {
        const input = document.getElementById("linkInscricao");
        input.select();
        input.setSelectionRange(0, 99999); // Para mobile
        document.execCommand("copy");
        alert("Link copiado para a área de transferência!");
    }
</script>
<?php $this->Html->scriptEnd(); ?>