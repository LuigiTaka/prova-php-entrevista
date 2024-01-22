<?php

$this->css("/css/base.css");

?>

<!doctype html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD de Usuários</title>

    <style>

        ul > li {
            display: inline-block;
        }


    </style>

    <?php foreach ($this->getStyles() as $index => $path) : ?>
        <link rel="stylesheet" href="<?= $path ?>">
    <?php endforeach; ?>


    <?php foreach ($this->getJs() as $index => $path) : ?>
        <script src="<?= $path ?>"></script>
    <?php endforeach; ?>

</head>
<body>
<header>

    <nav>
        <ul>
            <li><a href="/">Início</a></li>
            <li><a href="/usuarios">Lista de usuários</a></li>
        </ul>
    </nav>

</header>

<main>

    <?= $conteudo ?? "" ?>

</main>
</body>
</html>
