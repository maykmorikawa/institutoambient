<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Students'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="students form content">
            <?= $this->Form->create($student) ?>
            <fieldset>
                <legend><?= __('Add Student') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('data_nascimento');
                    echo $this->Form->control('genero');
                    echo $this->Form->control('estado_civil');
                    echo $this->Form->control('religiao');
                    echo $this->Form->control('naturalidade');
                    echo $this->Form->control('cor_etnia');
                    echo $this->Form->control('rg');
                    echo $this->Form->control('nis');
                    echo $this->Form->control('documentos_civis');
                    echo $this->Form->control('programas_sociais');
                    echo $this->Form->control('valor_beneficio');
                    echo $this->Form->control('cadunico_codigo');
                    echo $this->Form->control('cep');
                    echo $this->Form->control('endereco');
                    echo $this->Form->control('municipio');
                    echo $this->Form->control('pessoa_com_deficiencia');
                    echo $this->Form->control('tipo_deficiencia');
                    echo $this->Form->control('serie_estudada');
                    echo $this->Form->control('situacao_escolar');
                    echo $this->Form->control('instituicao_ensino');
                    echo $this->Form->control('encaminhado_por');
                    echo $this->Form->control('turma');
                    echo $this->Form->control('autorizo_imagem');
                    echo $this->Form->control('compromisso_social');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
