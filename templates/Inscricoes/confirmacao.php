<style>
    @media print {
    .no-print {
        display: none !important;
    }
}

</style>
<div class="container py-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3 class="mb-0">✅ Inscrição Concluída!</h3>
        </div>
        <div class="card-body">
            <div class="alert alert-success">
                <h4 class="alert-heading">Parabéns, <?= h($aluno->nome) ?>!</h4>
                <p>Sua inscrição na atividade <strong><?= h($atividade->nome) ?></strong> foi registrada com sucesso.
                </p>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h5>Detalhes:</h5>
                        <ul class="list-unstyled">
                            <li><strong>Código:</strong> <?= h($inscricao->id ?? 'N/A') ?></li>
                            <li><strong>Local:</strong> <?= h($atividade->local ?? 'A definir') ?></li> 
                            <li><strong>Aluno:</strong> <?= h($inscricao->aluno->nome_completo ?? 'Sem nome') ?></li>

                            <li><strong>Data da Inscrição:</strong>
                                <?= $inscricao->data_inscricao->format('d/m/Y H:i') ?>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <div class="d-grid gap-2">
                            <?= $this->Html->link(
                                'Imprimir Comprovante',
                                ['action' => 'comprovante', $inscricao->id, '?' => ['print' => '1']],
                                ['class' => 'btn btn-outline-info', 'target' => '_blank']
                            ) ?>

                            <?= $this->Html->link(
                                'Voltar às Atividades',
                                ['controller' => 'Atividades', 'action' => 'index'],
                                ['class' => 'btn btn-outline-secondary']
                            ) ?>

                            <!-- Botão para imprimir a página -->
                            <button type="button" onclick="window.print()" class="btn btn-outline-info">
                                Imprimir esta página
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<?php if ($this->request->getQuery('print') === '1'): ?>
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
<?php endif; ?>