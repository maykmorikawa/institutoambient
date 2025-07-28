<?php
/**
 * @var \App\View\AppView $this
 * @var array $settings
 * @var array $configKeys
 */
echo $this->Form->create(null, ['type' => 'file']);
?>

<h1>Editar Configurações</h1>

<?php foreach ($settings as $key => $setting): ?>
    <div class="mb-4">
        <label class="form-label"><strong><?= h($configKeys[$key]['label']) ?></strong></label><br>

        <?php if ($setting->type === 'image'): ?>
            <?php if (!empty($setting->value)): ?>
                <div>
                    <img src="<?= $this->Url->image($setting->value) ?>" alt="<?= h($key) ?>" style="max-height: 100px;">
                </div>
            <?php endif; ?>
            <?= $this->Form->control("{$key}_upload", ['type' => 'file', 'label' => false]) ?>
        <?php else: ?>
            <?= $this->Form->control("{$key}", [
                'value' => $setting->value,
                'label' => false,
                'placeholder' => 'Digite o valor...'
            ]) ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

<?= $this->Form->button(__('Salvar Configurações'), ['class' => 'btn btn-primary']) ?>
<?= $this->Form->end() ?>
