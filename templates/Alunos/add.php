<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aluno $aluno
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Alunos'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="alunos form content">
            <?= $this->Form->create($aluno) ?>
            <fieldset>
                <legend><?= __('Add Aluno') ?></legend>
                <?php
                echo $this->Form->control('user_id', ['options' => $users]);

                echo $this->Form->control('nome_completo');
                echo $this->Form->control('email');
                echo $this->Form->control('cpf');
                echo $this->Form->control('rg');
                echo $this->Form->control('nis');
                echo $this->Form->control('data_nascimento', ['empty' => true]);
                echo $this->Form->control('telefone');
                ?>
                <?php
                // Pega o atividade_id da URL
                $atividadeId = $this->request->getQuery('atividade_id');
                ?>

                <!-- Campo hidden para enviar o ID da atividade no form -->
                <?= $this->Form->control('atividade_id', [
                    'type' => 'hidden',
                    'value' => $atividadeId
                ]) ?>

                <!-- Exibe o nome da atividade em texto -->
                <p>
                    <strong>Atividade:</strong>
                    <?= h($atividades[$atividadeId] ?? 'Desconhecida') ?>
                </p>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>