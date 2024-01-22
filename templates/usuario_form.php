<?php

$template = new \TestePratico\Template("base");
ob_start();
?>
    <h1>Cadastro de Usuário</h1>
    <form action="/usuarios" method="POST" enctype="application/x-www-form-urlencoded">

        <label for="name">Nome</label>
        <input type="text" name="name" id="name" value="<?= $name ?? '' ?>">

        <label for="email">E-mail.</label>
        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">

        <label for="cor">Cor</label>
        <input type="text" name="cor" id="cor" list="colors">
        <datalist id="colors">
            <?php foreach ($colors as $id => $color): ?>
                <option> <?= $color ?> </option>
            <?php endforeach; ?>
        </datalist>

        <input type="text" name="id" hidden value="<?= $id ?? false ?>">

        <input type="submit" value="Salvar">
    </form>

<?php


$template->set('conteudo', ob_get_clean());
echo $template->render();