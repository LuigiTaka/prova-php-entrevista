<?php

require_once __DIR__ . "/../autoload.php";

$template = new \TestePratico\Template("base");
ob_start();
?>

<h1>Lista de Usuários</h1>

<a href='/usuarios/novo'>Novo usuário</a>

<?php if (!empty($errorMessage)): ?>
    <p> <?= $errorMessage ?> </p>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <p> <?= $message ?> </p>
<?php endif; ?>

<table>
    <thead>

    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user) : ?>
        <tr>
            <td> <?= $user->id ?> </td>
            <td> <?= $user->name ?> </td>
            <td><?= $user->email ?> </td>
            <td>
                <a href='#'>Editar</a>
                <a href='#'>Excluir</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php

$template->set("conteudo",ob_get_clean());
echo $template->render();