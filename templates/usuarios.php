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
                <td><?= $user['id'] ?></td>
                <td><?= $user['name'] ?></td>
                <td><?= $user['email'] ?></td>
                <td>
                    <div>
                        <?php foreach ($userColors[$user['id']] ?? [] as $idColor => $color) : ?>
                            <span class="esferico" style="background-color: <?= strtolower($color['name']) ?>"></span>
                        <?php endforeach; ?>
                    </div>
                    <button onclick="openModal(<?= $user['id'] ?>)">Adicionar Cor</button>

                </td>
                <td>
                    <a href='/usuarios/<?= $user['id'] ?>'>Editar</a>
                    <a href="#" class="rm" data-id="<?= $user['id'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal para adicionar cor -->
    <div id="modal" class="modal">
        <div class="modal-content">

            <label for="cor">Cores</label>
            <?php foreach ($colors as $idColor => $color): ?>
                <label class="d-inline-block" for="color<?= $idColor ?>">
                    <input type="checkbox" name="cores[]" value="<?= $idColor ?>"
                           id="color-<?= $idColor ?>">
                    <?= $color['name'] ?>
                    <span class="esferico" style="background-color: <?= strtolower($color['name']) ?>"></span>
                </label>
            <?php endforeach; ?>

            <button onclick="adicionarCor()">Adicionar</button>
            <button onclick="closeModal()">Cancelar</button>
        </div>
    </div>


<?php
$template->js("/js/usuarios.js");

$template->set("conteudo", ob_get_clean());
echo $template->render();