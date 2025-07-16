<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aula $aula
 * @var array<\App\Model\Entity\Aluno> $alunosDaAtividade
 * @var array<\App\Model\Entity\Presenca> $presencasRegistradas
 */
?>

<section class="page-title-section bg-img cover-background left-overlay-dark" data-overlay-dark="6"
    data-background="<?= WWW; ?>/site/img/bg/bg-07.jpg">
    <div class="container position-unset">
        <div class="page-title mx-1-6 mx-lg-2-0 mx-xl-2-6 mx-xxl-2-9">
            <div class="row">
                <div class="col-md-12">
                    <h1><?= __('Registrar Presença') ?></h1>
                </div>
                <div class="col-md-12">
                    <ul class="ps-0">
                        <li><a href="/">Home</a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Aulas', 'action' => 'index']) ?>"><?= __('Aulas') ?></a></li>
                        <li><a href="<?= $this->Url->build(['controller' => 'Aulas', 'action' => 'view', $aula->id]) ?>"><?= __('Aula') ?> #<?= h($aula->id) ?></a></li>
                        <li><a href="#!"><?= __('Registrar Presença') ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <div class="card card-style8">
                    <div class="card-header bg-primary text-white">
                        <h4 class="h5 mb-0">
                            <?= __('Registro de Presença para Aula') ?> #<?= h($aula->id) ?>
                            <small class="d-block mt-1">Data: <?= h($aula->data->format('d/m/Y')) ?></small>
                            <small class="d-block">Atividade: <?= h($aula->atividade->nome ?? 'N/A') ?></small>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="flash-messages" class="mb-3">
                        </div>

                        <?php if (empty($alunosDaAtividade)): ?>
                            <div class="alert alert-warning text-center">
                                <?= __('Nenhum aluno encontrado para esta atividade. Por favor, adicione alunos à atividade antes de registrar a presença.') ?>
                                <br><?= $this->Html->link(__('Adicionar Novo Aluno'), ['controller' => 'Alunos', 'action' => 'add', '?' => ['atividade_id' => $aula->atividade->id]], ['class' => 'btn btn-sm btn-outline-warning mt-2']) ?>
                            </div>
                        <?php else: ?>
                            <p class="lead text-muted mb-4"><?= __('Marque ou desmarque a caixa para registrar a presença de cada aluno.') ?></p>
                            <div class="list-group">
                                <?php foreach ($alunosDaAtividade as $aluno): ?>
                                    <?php
                                    // Verifica se já existe uma presença registrada para este aluno nesta aula
                                    $isPresente = false;
                                    $presencaId = null;
                                    if (isset($presencasRegistradas[$aluno->id])) {
                                        $isPresente = (bool)$presencasRegistradas[$aluno->id]->presente;
                                        $presencaId = $presencasRegistradas[$aluno->id]->id;
                                    }
                                    ?>
                                    <label class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="form-check form-switch d-flex align-items-center">
                                            <input
                                                class="form-check-input presence-toggle me-3"
                                                type="checkbox"
                                                role="switch"
                                                id="presenceSwitch-<?= h($aluno->id) ?>"
                                                data-aluno-id="<?= h($aluno->id) ?>"
                                                data-aula-id="<?= h($aula->id) ?>"
                                                <?= $isPresente ? 'checked' : '' ?>>
                                            <h6 class="mb-0"><?= h($aluno->nome_completo) ?></h6>
                                        </div>
                                        <span class="badge bg-secondary text-white rounded-pill" id="statusBadge-<?= h($aluno->id) ?>">
                                            <?= $isPresente ? __('Presente') : __('Ausente') ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 text-center">
                            <?= $this->Html->link(__('Voltar para Aulas'), ['controller' => 'Aulas', 'action' => 'index'], ['class' => 'butn-style3 btn-secondary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->Html->scriptStart(['block' => true]); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggles = document.querySelectorAll('.presence-toggle');
        const flashMessagesContainer = document.getElementById('flash-messages');

        toggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const alunoId = this.dataset.alunoId;
                const aulaId = this.dataset.aulaId;
                const presente = this.checked; // true ou false
                const statusBadge = document.getElementById(`statusBadge-${alunoId}`);

                // Limpa mensagens anteriores
                flashMessagesContainer.innerHTML = '';

                // Indica carregamento
                statusBadge.textContent = 'Aguarde...';
                statusBadge.classList.remove('bg-success', 'bg-danger', 'bg-secondary');
                statusBadge.classList.add('bg-info');


                fetch('<?= $this->Url->build(['action' => 'updatePresenceAjax', '_ext' => 'json']) ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': <?= json_encode($this->request->getAttribute('csrfToken')) ?> // Inclui o token CSRF
                        },
                        body: JSON.stringify({
                            aluno_id: alunoId,
                            aula_id: aulaId,
                            presente: presente ? 1 : 0 // Envia 1 para true, 0 para false
                        })
                    })
                    .then(response => {
                        // Checa se a resposta é JSON. Se não for, tenta ler como texto.
                        const contentType = response.headers.get("content-type");
                        if (contentType && contentType.indexOf("application/json") !== -1) {
                            return response.json();
                        } else {
                            return response.text().then(text => {
                                throw new Error(`Resposta não JSON: ${text}`);
                            });
                        }
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            // Atualiza a interface em caso de sucesso
                            statusBadge.textContent = presente ? 'Presente' : 'Ausente';
                            statusBadge.classList.remove('bg-info');
                            statusBadge.classList.add(presente ? 'bg-success' : 'bg-secondary');
                            displayFlashMessage('success', data.message);
                        } else {
                            // Reverte o toggle e exibe mensagem de erro
                            this.checked = !presente; // Reverte o estado do checkbox
                            statusBadge.textContent = presente ? 'Ausente' : 'Presente'; // Reverte o texto do badge
                            statusBadge.classList.remove('bg-info');
                            statusBadge.classList.add('bg-danger');
                            displayFlashMessage('danger', data.message + (data.errors ? ' ' + JSON.stringify(data.errors) : ''));
                        }
                    })
                    .catch(error => {
                        console.error('Erro na requisição AJAX:', error);
                        this.checked = !presente; // Reverte o estado do checkbox em caso de erro na rede/servidor
                        statusBadge.textContent = presente ? 'Ausente' : 'Presente'; // Reverte o texto do badge
                        statusBadge.classList.remove('bg-info');
                        statusBadge.classList.add('bg-danger');
                        displayFlashMessage('danger', 'Ocorreu um erro ao conectar com o servidor. Tente novamente.');
                    });
            });
        });

        function displayFlashMessage(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `<div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                                ${message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`;
            flashMessagesContainer.innerHTML = alertHtml;
        }
    });
</script>
<?php $this->Html->scriptEnd(); ?>