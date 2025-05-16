<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Atividade $atividade
 * @var string[]|\Cake\Collection\CollectionInterface $projetos
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $atividade->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $atividade->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Atividades'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="atividades form content">
            <?= $this->Form->create($atividade) ?>
            <fieldset>
                <legend><?= __('Edit Atividade') ?></legend>
                <?php
                    echo $this->Form->control('projeto_id', ['options' => $projetos]);
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('slug');
                    echo $this->Form->control('link_inscricao');
                    echo $this->Form->control('publicado');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
