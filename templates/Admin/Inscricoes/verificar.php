<!-- templates/Inscricoes/verificar.php -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Inscrição em: <?= h($atividade->nome) ?></h3>
                </div>
                <div class="card-body">
                    <?= $this->Form->create() ?>

                    <!-- Campo CPF com máscara -->
                    <div class="mb-3">
                        <?= $this->Form->control('cpf', [
                            'label' => 'CPF',
                            'class' => 'form-control',
                            'placeholder' => 'Digite seu CPF',
                            'required' => true,
                            'oninput' => 'formatarCPF(this)'
                        ]) ?>
                    </div>

                    <!-- Campo Data de Nascimento -->
                    <div class="mb-3">
                        <?= $this->Form->control('data_nascimento', [
                            'label' => 'Data de Nascimento',
                            'type' => 'date',
                            'class' => 'form-control',
                            'required' => true,
                            'max' => date('Y-m-d', strtotime('-10 years')),
                            'min' => date('Y-m-d', strtotime('-100 years'))
                        ]) ?>
                    </div>

                    <div class="d-grid">
                        <?= $this->Form->button('Verificar Cadastro', [
                            'class' => 'btn btn-primary btn-lg'
                        ]) ?>
                    </div>

                    <?= $this->Form->end() ?>

                    <hr>

                    <p class="text-center mt-3">
                        Não possui cadastro?
                        <?= $this->Html->link('Cadastre-se aqui', [
                            'controller' => 'Alunos',
                            'action' => 'add',
                            '?' => ['atividade_id' => $atividade->id]
                        ], ['class' => 'btn btn-outline-primary']) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para máscara de CPF -->
<script>
    function formatarCPF(campo) {
        let valor = campo.value.replace(/\D/g, "");
        valor = valor.substring(0, 11);

        if (valor.length > 9) {
            valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
        } else if (valor.length > 6) {
            valor = valor.replace(/(\d{3})(\d{3})(\d{3})/, "$1.$2.$3");
        } else if (valor.length > 3) {
            valor = valor.replace(/(\d{3})(\d{3})/, "$1.$2");
        }

        campo.value = valor;
    }
</script>