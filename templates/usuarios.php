<?php

$template = new \TestePratico\Template("base");
$template->css("/css/usuarios.css");
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
            <th>Cores</th>
            <th>Ação</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= $user->id ?></td>
                <td><?= $user->name ?></td>
                <td><?= $user->email ?></td>
                <td>
                    <?php foreach ($user->cores ?? [] as $cor) : ?>
                        <div class="cores" style="background-color: <?= $cor ?>"></div>
                    <?php endforeach; ?>
                    <button onclick="openModal(<?= $user->id ?>)">Adicionar Cor</button>

                </td>
                <td>
                    <a href='/usuario/<?= $user->id ?>'>Editar</a>
                    <a href="#" class="rm" data-id="<?= $user->id ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal para adicionar cor -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <label for="novaCor">Nova Cor:</label>
            <input type="text" id="novaCor" placeholder="Digite uma cor...">
            <button onclick="adicionarCor()">Adicionar</button>
            <button onclick="closeModal()">Cancelar</button>
        </div>
    </div>


<?php
$template->js("/js/usuarios.js");


$template->set("conteudo", ob_get_clean());
echo $template->render();