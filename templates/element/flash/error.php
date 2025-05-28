<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */

?>
<?php foreach ((array)$message as $msg): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Erro:</strong> <?= h($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endforeach; ?>