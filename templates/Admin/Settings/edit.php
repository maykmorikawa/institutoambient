<?php
/**
 * @var \App\View\AppView $this
 * @var array $settings
 * @var array $configKeys
 */
$this->assign('title', __('Editar Configurações do Sistema'));
?>

<div class="row">
    <div class="col-md-10 offset-md-1">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-0"><?= __('Editar Configurações do Sistema') ?></h3>
            </div>
            <div class="card-body">
                <?= $this->Form->create(null, ['type' => 'file']) ?> <!-- Importante: 'type' => 'file' para uploads -->
                <fieldset>
                    <legend><?= __('Imagens e Logos do Certificado') ?></legend>
                    <?php foreach ($configKeys as $key => $details): ?>
                        <?php if ($details['type'] === 'image'): ?>
                            <div class="mb-3">
                                <label class="form-label"><?= h($details['description']) ?></label>
                                <?php if (!empty($settings[$key]->value)): ?>
                                    <div class="mb-2">
                                        <img src="<?= $this->Url->image($details['path'] . $settings[$key]->value, ['fullBase' => true]) ?>" alt="<?= h($details['description']) ?>" style="max-width: 200px; height: auto; border: 1px solid #ddd;">
                                        <small class="text-muted d-block mt-1"><?= h($settings[$key]->value) ?></small>
                                    </div>
                                <?php endif; ?>
                                <?= $this->Form->control($key . '_file', [ // Nome do campo de arquivo
                                    'type' => 'file',
                                    'label' => false,
                                    'class' => 'form-control',
                                    'accept' => 'image/png, image/jpeg', // Aceita apenas PNG e JPEG
                                ]); ?>
                                <small class="form-text text-muted">Apenas arquivos PNG ou JPG são aceitos.</small>
                            </div>
                        <?php elseif ($details['type'] === 'string'): ?>
                            <div class="mb-3">
                                <?= $this->Form->control($key, [
                                    'label' => h($details['description']),
                                    'class' => 'form-control',
                                    'value' => $settings[$key]->value,
                                ]); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </fieldset>

                <?= $this->Form->button(__('Salvar Configurações'), ['class' => 'btn btn-primary mt-3']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>