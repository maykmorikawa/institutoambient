<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 * @var string $key
 */
echo $this->Form->create(null, ['type' => 'file']);
?>

<h1>Editar Configuração: <?= h($setting->description ?: $key) ?></h1>

<?php if ($setting->type === 'image'): ?>
    <?php if (!empty($setting->value)): ?>
        <div>
            <img src="<?= $this->Url->image($setting->value) ?>" alt="<?= h($key) ?>" style="max-height: 100px;">
        </div>
    <?php endif; ?>
    <?= $this->Form->control("value_upload", ['type' => 'file', 'label' => false]) ?>
<?php else: ?>
    <?= $this->Form->control("value", [
        'value' => $setting->value,
        'label' => false,
        'placeholder' => 'Digite o valor...'
    ]) ?>
<?php endif; ?>

<?= $this->Form->button(__('Salvar'), ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
