<?php

$template = new \TestePratico\Template("base");
ob_start();
?>
    <h1>Cadastro de Usuário</h1>
    <form action="/usuarios" method="POST" enctype="application/x-www-form-urlencoded">

        <label for="name">Nome</label>
        <input type="text" name="name" id="name">

        <label for="email">E-mail.</label>
        <input type="email" name="email" id="email">

        <input type="submit" value="Salvar">
    </form>

<?php


$template->set('conteudo', ob_get_clean());
echo $template->render();