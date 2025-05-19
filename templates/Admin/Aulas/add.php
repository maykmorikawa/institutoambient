<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 * @var \Cake\Collection\CollectionInterface|string[] $atividades
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Aulas'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="aulas form content">
            <?= $this->Form->create($aula) ?>
            <fieldset>
                <legend><?= __('Add Aula') ?></legend>
                <?php
                    echo $this->Form->control('atividade_id', ['options' => $atividades]);
                    echo $this->Form->control('data');
                    echo $this->Form->control('conteudo');
                    echo $this->Form->control('observacoes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
