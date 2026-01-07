<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Mensagens de Contacto</h1>
    
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Nome</th>
                            <th>Assunto</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact): ?>
                        <tr style="<?= $contact->viewed == 0 ? 'font-weight: bold; background-color: #f8f9fc;' : '' ?>">
                            <td>
                                <?php if ($contact->viewed == 0): ?>
                                    <span class="badge badge-danger">Nova</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Lida</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $contact->created->format('d/m/Y H:i') ?></td>
                            <td><?= h($contact->name) ?></td>
                            <td><?= h($contact->subject) ?></td>
                            <td>
                                <?= $this->Html->link('<i class="fas fa-eye"></i> Ler', 
                                    ['action' => 'view', $contact->id], 
                                    ['escape' => false, 'class' => 'btn btn-primary btn-sm']) 
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< Anterior') ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next('Próxima >') ?>
                </ul>
            </div>
        </div>
    </div>
</div>