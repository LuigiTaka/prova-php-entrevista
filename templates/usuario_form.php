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

        <label for="cor">Cores</label>
        <?php foreach ($colors as $idColor => $color): ?>
            <label class="d-inline-block" for="<?= $color ?>">
                <input type="checkbox" name="cores[]" value="<?= $idColor ?>" id="<?= $color ?>">
                <?= $color ?>
                <span class="esferico" style="background-color: <?= strtolower($color) ?>"></span>
            </label>
        <?php endforeach; ?>

        <label>
            <input type="text" name="id" hidden value="<?= $id ?? false ?>">
        </label>

        <input type="submit" value="Salvar">
    </form>
<?php


$template->set('conteudo', ob_get_clean());
echo $template->render();