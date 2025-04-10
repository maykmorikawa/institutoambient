<?= $this->Form->create($user) ?>
<fieldset style="margin-bottom:25px;">
    <h2>Acessar</h2>
    <?php

    echo $this->Form->control('email', ['class' => 'form-control', 'label' => 'E-mail']);

    echo $this->Form->control('password', ['class' => 'form-control', 'label' => 'Senha']);
    ?>
</fieldset>
<?= $this->Form->button(__('Entrar'), ['class' => 'btn btn-info btn-block']) ?>
<?= $this->Form->end() ?>
<br>
<hr />


<a href="/forget" class='btn btn-warning btn-block'>Esqueci a senha</a>