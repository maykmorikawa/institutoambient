<!-- templates/Inscricoes/processar_inscricao.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Inscrição Confirmada!</h3>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-check-circle fa-5x text-success mb-4"></i>
                    <h4 class="mb-3">Você está inscrito em: <?= h($atividade->nome) ?></h4>
                    <p class="mb-4">Anote o código da atividade: <strong><?= h($atividade->codigo) ?></strong></p>
                    
                    <?= $this->Html->link('Voltar à Página da Atividade', [
                        'controller' => 'Atividades',
                        'action' => 'view',
                        $atividade->id
                    ], ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>