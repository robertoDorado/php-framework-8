<?php $this->layout("_theme") ?>
<form action="/form" method="post">
    <label for="writeName">Escreva seu nome</label>
    <input type="text" name="writeName">
    <input type="hidden" name="csrfToken" value="<?= session()->csrf_token ?>">
    <button type="submit">Enviar</button>
</form>