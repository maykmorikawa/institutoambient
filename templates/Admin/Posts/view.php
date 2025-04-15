<?php 
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><?= h($post->title) ?></h2>
        <div>
            <?= $this->Html->link('<i class="bi bi-pencil-square"></i> Editar', ['action' => 'edit', $post->id], ['class' => 'btn btn-outline-secondary me-2', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="bi bi-trash"></i> Excluir', ['action' => 'delete', $post->id], [
                'class' => 'btn btn-outline-danger',
                'escape' => false,
                'confirm' => __('Tem certeza que deseja excluir o post #{0}?', $post->id),
            ]) ?>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-bold">Detalhes</div>
        <div class="card-body">
            <table class="table table-striped">
                <tr>
                    <th><?= __('Título') ?></th>
                    <td><?= h($post->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Categoria') ?></th>
                    <td><?= $post->hasValue('category') ? $this->Html->link($post->category->name, ['controller' => 'Categories', 'action' => 'view', $post->category->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Autor') ?></th>
                    <td><?= $post->hasValue('user') ? $this->Html->link($post->user->name, ['controller' => 'Users', 'action' => 'view', $post->user->id]) : '-' ?></td>
                </tr>
                <tr>
                    <th><?= __('Slug') ?></th>
                    <td><?= h($post->slug) ?></td>
                </tr>
                <tr>
                    <th><?= __('Imagem') ?></th>
                    <td>
                        <?php if ($post->image): ?>
                            <?= $this->Html->image($post->image, ['alt' => $post->title, 'style' => 'max-height:100px;']) ?>
                        <?php else: ?>
                            <span class="text-muted">Sem imagem</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
                        <span class="badge bg-<?= $post->status === 'ativo' ? 'success' : 'secondary' ?>">
                            <?= h(ucfirst($post->status)) ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Publicado') ?></th>
                    <td>
                        <?= $post->published ? '<span class="badge bg-primary">Sim</span>' : '<span class="badge bg-warning text-dark">Não</span>' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= $post->created->format('d/m/Y H:i') ?></td>
                </tr>
                <tr>
                    <th><?= __('Atualizado em') ?></th>
                    <td><?= $post->modified->format('d/m/Y H:i') ?></td>
                </tr>
            </table>
        </div>
    </div>

    <div class="mb-4">
        <h4>Resumo</h4>
        <blockquote class="blockquote ps-3 border-start border-3 border-primary">
            <?= $this->Text->autoParagraph(h($post->excerpt)); ?>
        </blockquote>
    </div>

    <div class="mb-4">
        <h4>Conteúdo</h4>
        <blockquote class="blockquote ps-3 border-start border-3 border-dark">
            <?= $this->Text->autoParagraph(h($post->content)); ?>
        </blockquote>
    </div>

    <?php if (!empty($post->tags)) : ?>
    <div class="mb-4">
        <h4>Tags relacionadas</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Criado em</th>
                        <th>Atualizado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($post->tags as $tag): ?>
                    <tr>
                        <td><?= $tag->id ?></td>
                        <td><?= h($tag->name) ?></td>
                        <td><?= h($tag->slug) ?></td>
                        <td><?= h($tag->created) ?></td>
                        <td><?= h($tag->modified) ?></td>
                        <td>
                            <?= $this->Html->link('Ver', ['controller' => 'Tags', 'action' => 'view', $tag->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?= $this->Html->link('Editar', ['controller' => 'Tags', 'action' => 'edit', $tag->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                            <?= $this->Form->postLink('Excluir', ['controller' => 'Tags', 'action' => 'delete', $tag->id], [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'confirm' => __('Tem certeza que deseja excluir a tag #{0}?', $tag->id),
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!empty($post->comments)) : ?>
    <div class="mb-4">
        <h4>Comentários</h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Autor</th>
                        <th>Email</th>
                        <th>Conteúdo</th>
                        <th>Status</th>
                        <th>Criado em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($post->comments as $comment): ?>
                    <tr>
                        <td><?= $comment->id ?></td>
                        <td><?= h($comment->user_name) ?></td>
                        <td><?= h($comment->email) ?></td>
                        <td><?= h($comment->content) ?></td>
                        <td><?= h($comment->status) ?></td>
                        <td><?= h($comment->created->format('d/m/Y H:i')) ?></td>
                        <td>
                            <?= $this->Html->link('Ver', ['controller' => 'Comments', 'action' => 'view', $comment->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?= $this->Html->link('Editar', ['controller' => 'Comments', 'action' => 'edit', $comment->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                            <?= $this->Form->postLink('Excluir', ['controller' => 'Comments', 'action' => 'delete', $comment->id], [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'confirm' => __('Deseja realmente excluir o comentário #{0}?', $comment->id),
                            ]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
