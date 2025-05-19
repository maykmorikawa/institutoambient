<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Presenca $presenca
 * @var \Cake\Collection\CollectionInterface|string[] $aulas
 * @var \Cake\Collection\CollectionInterface|string[] $alunos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Presencas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="presencas form content">
            <?= $this->Form->create($presenca) ?>
            <fieldset>
                <legend><?= __('Add Presenca') ?></legend>
                <?php
                    echo $this->Form->control('aula_id', ['options' => $aulas]);
                    echo $this->Form->control('aluno_id', ['options' => $alunos]);
                    echo $this->Form->control('presente');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
