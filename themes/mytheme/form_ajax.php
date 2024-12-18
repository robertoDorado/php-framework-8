<?php $this->layout("_theme") ?>
<form action="/form-ajax" method="post" id="formData">
    <label for="writeName">Escreva seu nome (AJAX)</label>
    <input type="text" name="writeName">
    <input type="hidden" name="csrfToken" value="<?= session()->csrf_token ?>">
    <button type="submit">Enviar</button>
</form>

<script>
    document.getElementById("formData").addEventListener("submit", function(event) {
        event.preventDefault()
        const form = new FormData(this)
        fetch(this.action, {
            method: "POST",
            body: form
        }).then(response => response.json())
        .then(function(response) {
            console.log(response)
        })
    })
</script>