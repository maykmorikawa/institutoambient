<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string|string[] $message
 */
?>

<?php foreach ((array) $message as $msg): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fas fa-exclamation-triangle me-2"></i>Erro:</strong> <?= h($msg) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php endforeach; ?>