<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Setting $setting
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Setting'), ['action' => 'edit', $setting->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __('Are you sure you want to delete # {0}?', $setting->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Settings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Setting'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="settings view content">
            <h3><?= h($setting->site_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Site Name') ?></th>
                    <td><?= h($setting->site_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logo') ?></th>
                    <td><?= h($setting->logo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($setting->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($setting->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($setting->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Site Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($setting->site_description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>