<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 */
?>
<div class="container mt-5">
    <h1><?= h($atividade->titulo) ?></h1>
    <p><?= h($atividade->descricao) ?></p>

    <p><strong>Projeto:</strong> <?= h($atividade->projeto->titulo ?? '---') ?></p>

    <?= $this->Html->link('Preencher Inscrição', ['controller' => 'Inscricoes', 'action' => 'add', '?' => ['atividade_id' => $atividade->id]], ['class' => 'btn btn-primary']) ?>
</div>
