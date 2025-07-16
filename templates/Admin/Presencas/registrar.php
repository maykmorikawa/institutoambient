<h1>Registrar Presença para Aula: <?= h($aula->conteudo) ?> (<?= $aula->data->format('d/m/Y') ?>)</h1>
<p>Atividade: <?= h($aula->atividade->nome) ?></p>

<div id="flash-messages"></div>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Aluno</th>
            <th>Presente</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($alunosDaAtividade)): ?>
            <tr>
                <td colspan="3" class="text-center">Nenhum aluno encontrado para esta atividade.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($alunosDaAtividade as $aluno): ?>
                <?php
                // Verifica se já existe um registro de presença para este aluno e aula
                $is_presente = false;
                if (isset($presencasRegistradas[$aluno->id])) {
                    $is_presente = (bool)$presencasRegistradas[$aluno->id]->presente;
                }
                ?>
                <tr id="row-<?= $aluno->id ?>">
                    <td><?= h($aluno->nome_completo) ?></td>
                    <td>
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input presence-checkbox"
                                type="checkbox"
                                role="switch"
                                id="presence-<?= $aluno->id ?>"
                                data-aluno-id="<?= $aluno->id ?>"
                                data-aula-id="<?= $aula->id ?>"
                                <?= $is_presente ? 'checked' : '' ?>>
                            <label class="form-check-label" for="presence-<?= $aluno->id ?>"></label>
                        </div>
                    </td>
                    <td class="text-center status-col">
                        <span class="status-indicator" id="status-<?= $aluno->id ?>"></span>
                        <div class="spinner-border spinner-border-sm text-primary d-none" role="status" id="spinner-<?= $aluno->id ?>">
                            <span class="visually-hidden">Carregando...</span>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php // Remova o botão de submit principal 
?>
<?php // $this->Form->button(__('Salvar Presenças')) 
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Função para exibir mensagens flash temporariamente
        function showFlashMessage(message, type = 'success') {
            const flashDiv = $('#flash-messages');
            const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
            flashDiv.append(alertHtml);
            setTimeout(() => {
                flashDiv.find('.alert').first().alert('close');
            }, 3000); // Fecha após 3 segundos
        }

        $('.presence-checkbox').on('change', function() {
            const checkbox = $(this);
            const alunoId = checkbox.data('aluno-id');
            const aulaId = checkbox.data('aula-id');
            const presente = checkbox.is(':checked') ? 1 : 0; // 1 para presente, 0 para ausente

            const statusIndicator = $('#status-' + alunoId);
            const spinner = $('#spinner-' + alunoId);

            // Oculta o indicador de status anterior e mostra o spinner
            statusIndicator.removeClass('text-success text-danger').html('');
            spinner.removeClass('d-none');

            $.ajax({
                url: '<?= $this->Url->build(['controller' => 'Presencas', 'action' => 'updatePresenceAjax']) ?>',
                type: 'POST',
                data: {
                    aluno_id: alunoId,
                    aula_id: aulaId,
                    presente: presente,
                    _csrfToken: '<?= $this->request->getParam('_csrfToken') ?>' // CSRF token para segurança
                },
                dataType: 'json', // Espera uma resposta JSON
                success: function(response) {
                    spinner.addClass('d-none'); // Oculta o spinner
                    if (response.status === 'success') {
                        statusIndicator.addClass('text-success').html('<i class="bi bi-check-circle-fill"></i> Salvo'); // Ícone de sucesso (ex: Bootstrap Icons)
                        showFlashMessage(response.message, 'success');
                    } else {
                        statusIndicator.addClass('text-danger').html('<i class="bi bi-x-circle-fill"></i> Erro'); // Ícone de erro
                        showFlashMessage(response.message, 'danger');
                        // Opcional: reverter o checkbox se houver erro grave
                        checkbox.prop('checked', !presente);
                    }
                },
                error: function(xhr, status, error) {
                    spinner.addClass('d-none'); // Oculta o spinner
                    statusIndicator.addClass('text-danger').html('<i class="bi bi-x-circle-fill"></i> Erro');
                    showFlashMessage('Erro de comunicação com o servidor: ' + xhr.responseJSON?.message || error, 'danger');
                    // Reverte o checkbox se a requisição falhar
                    checkbox.prop('checked', !presente);
                }
            });
        });
    });
</script>

<style>
    /* Estilos básicos para o status */
    .status-col {
        min-width: 80px;
        /* Garante espaço para o texto e ícone */
    }

    .status-indicator {
        font-size: 0.9em;
        vertical-align: middle;
    }

    .status-indicator i {
        margin-right: 5px;
    }

    /* Estilos para os ícones do Bootstrap Icons (se estiver usando) */
    .bi-check-circle-fill {
        color: #28a745;
    }

    /* Verde para sucesso */
    .bi-x-circle-fill {
        color: #dc3545;
    }

    /* Vermelho para erro */
</style>