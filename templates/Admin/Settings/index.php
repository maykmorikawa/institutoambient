<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Setting> $settings
 */
$this->assign('title', __('Lista de Configurações'));
?>
<div class="settings index content">
    <?= $this->Html->link(__('Editar Configurações'), ['action' => 'edit'], ['class' => 'button float-right']) ?>
    <h3><?= __('Configurações do Sistema') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('key_name', __('Chave')) ?></th>
                    <th><?= $this->Paginator->sort('value', __('Valor')) ?></th>
                    <th><?= $this->Paginator->sort('type', __('Tipo')) ?></th>
                    <th><?= $this->Paginator->sort('description', __('Descrição')) ?></th>
                    <th><?= $this->Paginator->sort('created', __('Criado Em')) ?></th>
                    <th><?= $this->Paginator->sort('modified', __('Modificado Em')) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($settings as $setting): ?>
                <tr>
                    <td><?= h($setting->key_name) ?></td>
                    <td>
                        <?php if ($setting->type === 'image' && !empty($setting->value)): ?>
                            <?php
                                // Assumindo que o caminho base para uploads é webroot/img/
                                // E o path está salvo como 'img/backgrounds/' ou 'img/logos/'
                                $imagePath = '';
                                if (strpos($setting->key_name, 'bg_page') !== false) {
                                    $imagePath = 'img/backgrounds/';
                                } elseif (strpos($setting->key_name, 'logo_') !== false) {
                                    $imagePath = 'img/logos/';
                                }
                            ?>
                            <img src="<?= $this->Url->image($imagePath . $setting->value, ['fullBase' => true]) ?>" alt="<?= h($setting->description) ?>" style="max-width: 100px; height: auto;">
                            <br><small><?= h($setting->value) ?></small>
                        <?php else: ?>
                            <!-- CORREÇÃO APLICADA AQUI: Usando ?? '' para garantir que $setting->value seja uma string -->
                            <?= $this->Text->truncate(h($setting->value ?? ''), 50, ['exact' => false]) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= h($setting->type) ?></td>
                    <td><?= h($setting->description) ?></td>
                    <td><?= h($setting->created) ?></td>
                    <td><?= h($setting->modified) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('Primeira')) ?>
            <?= $this->Paginator->prev('< ' . __('Anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('Próxima') . ' >') ?>
            <?= $this->Paginator->last(__('Última') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de um total de {{count}}')) ?></p>
    </div>
</div>