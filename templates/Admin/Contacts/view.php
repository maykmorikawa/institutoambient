<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Detalhes da Mensagem #<?= $contact->id ?></h6>
            <?= $this->Html->link('Voltar', ['action' => 'index'], ['class' => 'btn btn-sm btn-secondary']) ?>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nome:</strong> <?= h($contact->name) ?></p>
                    <p><strong>E-mail:</strong> <?= h($contact->email) ?></p>
                    <p><strong>Telefone:</strong> <?= h($contact->phone ?? 'Não informado') ?></p>
                </div>
                <div class="col-md-6 text-right">
                    <p><strong>Data de Envio:</strong> <?= $contact->created->format('d/m/Y H:i') ?></p>
                </div>
            </div>
            <hr>
            <h5><strong>Assunto:</strong> <?= h($contact->subject) ?></h5>
            <div class="p-3 bg-light border rounded">
                <strong>Mensagem:</strong><br>
                <?= nl2br(h($contact->message)) ?>
            </div>
        </div>
    </div>
</div>