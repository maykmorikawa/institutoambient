<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inscrico $inscrico
 * @var \Cake\Collection\CollectionInterface|string[] $alunos
 * @var \Cake\Collection\CollectionInterface|string[] $atividades
 * @var \Cake\Collection\CollectionInterface|string[] $users
 * @var \Cake\Collection\CollectionInterface|string[] $responsavels
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inscricoes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inscricoes form content">
            <?= $this->Form->create($inscrico) ?>
            <fieldset>
                <legend><?= __('Add Inscrico') ?></legend>
                <?php
                    echo $this->Form->control('aluno_id', ['options' => $alunos]);
                    echo $this->Form->control('atividade_id', ['options' => $atividades]);
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('responsavel_id', ['options' => $responsavels, 'empty' => true]);
                    echo $this->Form->control('data_inscricao', ['empty' => true]);
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
