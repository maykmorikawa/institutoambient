<!-- templates/Contatos/index.php -->
<div class="container py-5">
    <h2 class="h3 mb-4">Formulário Para Contato</h2>

    <?= $this->Flash->render() ?>

    <form class="quform" action="<?= $this->Url->build(['action' => 'enviar']) ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-6">
                <label>Seu Nome <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="name" placeholder="Seu nome aqui" required>
            </div>

            <div class="col-md-6">
                <label>Seu Email <span class="text-danger">*</span></label>
                <input class="form-control" type="email" name="email" placeholder="Seu email aqui" required>
            </div>

            <div class="col-md-6">
                <label>Assunto <span class="text-danger">*</span></label>
                <input class="form-control" type="text" name="subject" placeholder="Seu assunto aqui" required>
            </div>

            <div class="col-md-6">
                <label>Telefone</label>
                <input class="form-control" type="text" name="phone" placeholder="Seu telefone aqui">
            </div>

            <div class="col-md-12">
                <label>Mensagem <span class="text-danger">*</span></label>
                <textarea class="form-control" name="message" rows="3" placeholder="Diga-nos algumas palavras" required></textarea>
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-primary" type="submit">Enviar Mensagem</button>
            </div>
        </div>
    </form>
</div>
