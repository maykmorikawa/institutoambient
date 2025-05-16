<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Student'), ['action' => 'edit', $student->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Student'), ['action' => 'delete', $student->id], ['confirm' => __('Are you sure you want to delete # {0}?', $student->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Students'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Student'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="students view content">
            <h3><?= h($student->genero) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $student->hasValue('user') ? $this->Html->link($student->user->name, ['controller' => 'Users', 'action' => 'view', $student->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Genero') ?></th>
                    <td><?= h($student->genero) ?></td>
                </tr>
                <tr>
                    <th><?= __('Estado Civil') ?></th>
                    <td><?= h($student->estado_civil) ?></td>
                </tr>
                <tr>
                    <th><?= __('Religiao') ?></th>
                    <td><?= h($student->religiao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Naturalidade') ?></th>
                    <td><?= h($student->naturalidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cor Etnia') ?></th>
                    <td><?= h($student->cor_etnia) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rg') ?></th>
                    <td><?= h($student->rg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nis') ?></th>
                    <td><?= h($student->nis) ?></td>
                </tr>
                <tr>
                    <th><?= __('Valor Beneficio') ?></th>
                    <td><?= h($student->valor_beneficio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cadunico Codigo') ?></th>
                    <td><?= h($student->cadunico_codigo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cep') ?></th>
                    <td><?= h($student->cep) ?></td>
                </tr>
                <tr>
                    <th><?= __('Endereco') ?></th>
                    <td><?= h($student->endereco) ?></td>
                </tr>
                <tr>
                    <th><?= __('Municipio') ?></th>
                    <td><?= h($student->municipio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo Deficiencia') ?></th>
                    <td><?= h($student->tipo_deficiencia) ?></td>
                </tr>
                <tr>
                    <th><?= __('Serie Estudada') ?></th>
                    <td><?= h($student->serie_estudada) ?></td>
                </tr>
                <tr>
                    <th><?= __('Situacao Escolar') ?></th>
                    <td><?= h($student->situacao_escolar) ?></td>
                </tr>
                <tr>
                    <th><?= __('Instituicao Ensino') ?></th>
                    <td><?= h($student->instituicao_ensino) ?></td>
                </tr>
                <tr>
                    <th><?= __('Turma') ?></th>
                    <td><?= h($student->turma) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($student->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Nascimento') ?></th>
                    <td><?= h($student->data_nascimento) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($student->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($student->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pessoa Com Deficiencia') ?></th>
                    <td><?= $student->pessoa_com_deficiencia ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Autorizo Imagem') ?></th>
                    <td><?= $student->autorizo_imagem ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Compromisso Social') ?></th>
                    <td><?= $student->compromisso_social ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Documentos Civis') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($student->documentos_civis)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Programas Sociais') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($student->programas_sociais)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Encaminhado Por') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($student->encaminhado_por)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>