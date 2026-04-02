<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Post $post
 */
?>

<div class="posts view content">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h4 mb-0 text-gray-800"><i class="fas fa-eye mr-2 text-primary"></i><?= __('Visualizar Postagem') ?></h1>
        <div class="btn-group shadow-sm">
            <?= $this->Html->link('<i class="fas fa-chevron-left mr-1"></i> Lista', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary', 'escape' => false]) ?>
            <?= $this->Html->link('<i class="fas fa-edit mr-1 text-white-50"></i> Editar', ['action' => 'edit', $post->id], ['class' => 'btn btn-sm btn-primary', 'escape' => false]) ?>
            <?= $this->Form->postLink('<i class="fas fa-trash mr-1 text-white-50"></i> Excluir', ['action' => 'delete', $post->id], [
                'class' => 'btn btn-sm btn-danger',
                'escape' => false,
                'confirm' => __('Deseja realmente remover este post?'),
            ]) ?>
        </div>
    </div>

    <div class="row">
        <!-- Coluna Principal -->
        <div class="col-lg-8">
            <!-- Card de Conteúdo -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center bg-white border-bottom-primary">
                    <h6 class="m-0 font-weight-bold text-primary">Conteúdo Detalhado</h6>
                    <div>
                        <span class="badge badge-<?= $post->status === 'publicado' ? 'success' : 'warning' ?> p-2 px-3">
                           <i class="fas fa-<?= $post->status === 'publicado' ? 'check' : 'clock' ?> mr-1"></i> <?= h(ucfirst($post->status)) ?>
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h2 class="font-weight-bold text-gray-900 mb-4"><?= h($post->title) ?></h2>
                    
                    <?php if ($post->excerpt): ?>
                        <div class="lead p-4 bg-light rounded border-left-info mb-4 shadow-sm" style="font-style: italic;">
                            <h6 class="font-weight-bold text-info small text-uppercase mb-2">Resumo:</h6>
                            <?= h($post->excerpt) ?>
                        </div>
                    <?php endif; ?>

                    <div class="post-body text-gray-800" style="line-height: 1.8; font-size: 1.1rem;">
                        <?= $post->content ?>
                    </div>
                </div>
            </div>

            <!-- Galeria de Imagens -->
            <?php if (!empty($post->post_images)): ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-images mr-2"></i>Mídias Vinculadas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($post->post_images as $img): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 shadow-sm transition-hover">
                                        <div class="position-relative">
                                            <img src="<?= $this->Url->build('/img/uploads/' . $img->filename) ?>" 
                                                 class="card-img-top rounded shadow-sm" style="height: 180px; object-fit: cover;" alt="Post Media">
                                            <?php if ($img->is_featured): ?>
                                                <span class="badge badge-primary position-absolute m-2 px-2 py-1 shadow" style="top:0; left:0;">
                                                    <i class="fas fa-star mr-1"></i>Destaque
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer bg-white text-center p-2">
                                            <small class="text-muted"><?= h($img->filename) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Coluna Lateral -->
        <div class="col-lg-4">
            <!-- Informações do Post -->
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary small text-uppercase">Informações Gerais</h6>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="fas fa-user-edit mr-2"></i>Autor:</span>
                            <span class="font-weight-bold"><?= $post->hasValue('user') ? h($post->user->name) : '-' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="fas fa-folder-open mr-2"></i>Categoria:</span>
                            <span class="badge badge-light border text-primary"><?= $post->hasValue('category') ? h($post->category->name) : 'Sem categoria' ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="fas fa-calendar-plus mr-2"></i>Criado:</span>
                            <span class="text-dark"><?= $post->created->format('d/m/Y H:i') ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="text-muted"><i class="fas fa-calendar-check mr-2"></i>Publicado:</span>
                            <span class="text-dark"><?= $post->published ? $post->published->format('d/m/Y H:i') : '<span class="text-warning">Não publicado</span>' ?></span>
                        </li>
                        <li class="list-group-item p-3">
                            <span class="text-muted small text-uppercase font-weight-bold d-block mb-1">Link Amigável:</span>
                            <code class="small d-block p-2 bg-light border rounded">/post/<?= h($post->slug) ?></code>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tags -->
            <div class="card shadow mb-4 border-left-dark">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-dark small text-uppercase">Tags Aplicadas</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($post->tags)): ?>
                        <?php foreach ($post->tags as $tag): ?>
                            <div class="badge badge-dark p-2 mb-2 mr-1 shadow-xs">
                                <i class="fas fa-tag mr-1 opacity-50"></i> <?= h($tag->name) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-3">
                            <i class="fas fa-tags fa-2x text-gray-200 mb-2"></i>
                            <p class="text-muted small mb-0">Nenhuma tag vinculada.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Widget Rápido -->
            <div class="card shadow bg-gradient-primary text-white border-0 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div style="opacity: 0.1; position: absolute; right: -10px; bottom: -10px;">
                        <i class="fas fa-newspaper fa-7x"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">Visto por Todos?</h5>
                    <p class="small mb-3">Este post está <?= $post->status === 'publicado' ? 'atualmente online' : 'em modo rascunho' ?>.</p>
                    <?= $this->Html->link('Ver no Front-end', ['prefix' => false, 'controller' => 'Posts', 'action' => 'view', $post->slug], ['class' => 'btn btn-sm btn-light btn-block font-weight-bold', 'target' => '_blank']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover:hover { transform: translateY(-5px); transition: all 0.3s ease; }
    .shadow-xs { shadow: 0 .125rem .25rem rgba(0,0,0,.08) !important; }
    .italic { font-style: italic; }
    .opacity-75 { opacity: 0.75; }
</style>