<style>
    /* Estilo para esconder elementos na impressão */
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6" data-background="img/banner/page-title.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1>Confirmação de Inscrição</h1> </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="#!">Confirmação</a></li> </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row justify-content-center"> <div class="col-lg-8 col-md-10"> <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h3 class="mb-0">✅ Inscrição Concluída!</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <h4 class="alert-heading">Parabéns, <?= h($aluno->nome_completo ?? $aluno->nome) ?>!</h4>
                            <p>Sua inscrição na atividade **<?= h($atividade->nome) ?>** foi registrada com sucesso.</p>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Detalhes da Inscrição:</h5>
                                    <ul class="list-unstyled">
                                        <li>**Código:** <?= h($inscricao->id ?? 'N/A') ?></li>
                                        <li>**Local:** <?= h($atividade->local ?? 'A definir') ?></li>
                                        <li>**Aluno:** <?= h($inscricao->aluno->nome_completo ?? 'Sem nome') ?></li>
                                        <li>**Data da Inscrição:**
                                            <?= $inscricao->data_inscricao->format('d/m/Y H:i') ?>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6 no-print"> <div class="d-grid gap-2">
                                        <?= $this->Html->link(
                                            'Imprimir Comprovante',
                                            ['action' => 'comprovante', $inscricao->id, '?' => ['print' => '1']],
                                            ['class' => 'btn btn-outline-info butn-style3 mb-2', 'target' => '_blank']
                                        ) ?>

                                        <?= $this->Html->link(
                                            'Voltar às Atividades',
                                            ['controller' => 'Atividades', 'action' => 'index'],
                                            ['class' => 'btn btn-outline-secondary butn-style3 mb-2']
                                        ) ?>

                                        <button type="button" onclick="window.print()" class="btn btn-outline-info butn-style3">
                                            Imprimir esta página
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($this->request->getQuery('print') === '1'): ?>
    <script>
        window.onload = function () {
            window.print();
        };
    </script>
<?php endif; ?>