<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface<\App\Model\Entity\Tag> $tags
 */
?>
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary"><?= __('Tags') ?></h6>
        <?= $this->Html->link(__('New Tag'), ['action' => 'add'], ['class' => 'btn btn-primary']) ?>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('name') ?></th>
                        <th><?= $this->Paginator->sort('slug') ?></th>
                        <th><?= $this->Paginator->sort('created') ?></th>
                        <th><?= $this->Paginator->sort('modified') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tags as $tag): ?>
                    <tr>
                        <td><?= $this->Number->format($tag->id) ?></td>
                        <td><?= h($tag->name) ?></td>
                        <td><?= h($tag->slug) ?></td>
                        <td><?= h($tag->created) ?></td>
                        <td><?= h($tag->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $tag->id], ['class' => 'btn btn-sm btn-outline-secondary']) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tag->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $tag->id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $tag->id),
                                    'class' => 'btn btn-sm btn-outline-danger'
                                ]
                            ) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="paginator mt-3">
            <ul class="pagination justify-content-center">
                <?= $this->Paginator->first('<< ' . __('first'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'page-link']) ?>
                <?= $this->Paginator->numbers(['class' => 'page-link']) ?>
                <?= $this->Paginator->next(__('next') . ' >', ['class' => 'page-link']) ?>
                <?= $this->Paginator->last(__('last') . ' >>', ['class' => 'page-link']) ?>
            </ul>
            <p class="text-center">
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </p>
        </div>
    </div>
</div>
