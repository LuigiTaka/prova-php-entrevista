<?php

namespace TestePratico\Controller;

use TestePratico\Connection;
use TestePratico\Exceptions\RequestException;
use TestePratico\Models\UsuariosModel;
use TestePratico\Request;
use TestePratico\Response;

class UsuariosController
{


    /**
     * @param Request $request
     * @param Connection $connection
     * @return Response
     */
    public static function get(Request $request, Connection $connection): Response
    {
        $users = $connection->query("SELECT * FROM users");
        $errorMessage = $_SESSION['error'] ?? false;
        $message = $_SESSION['message'];
        unset($_SESSION['error']);
        unset($_SESSION['message']);
        ob_start();
        echo "

                   <p>$errorMessage</p>
                   <p>$message </p>
<table border='1'>
<a href='/usuarios/novo'>Novo usuário</a>
    <tr>
        <th>ID</th>    
        <th>Nome</th>    
        <th>Email</th>
        <th>Ação</th>    
    </tr>
";

        foreach ($users as $user) {

            echo sprintf("<tr>
                      <td>%s</td>
                      <td>%s</td>
                      <td>%s</td>
                      <td>
                           <a href='#'>Editar</a>
                           <a href='#'>Excluir</a>
                      </td>
                   </tr>",
                $user->id, $user->name, $user->email);

        }

        echo "</table>";
        $page = ob_get_clean();
        return Response::response()->setStatus(200)->setBody($page);
    }

    /**
     * @throws \Throwable
     */
    public static function post(Request $request, Connection $connection): Response
    {
        $nome = $request->post("name");
        $email = $request->post("email");

        try {

            if (empty($nome)) {
                throw new RequestException("Informe o nome do usuário.", 422);

            } else if (empty($email)) {
                throw new RequestException("Informe o e-mail do usuário.", 422);
            }


            $usuariosModel = new UsuariosModel($connection);
            $id = $usuariosModel->insert([
                "name" => $nome,
                "email" => $email
            ]);

            $_SESSION['message'] = "Usuário criado!";
            $response = Response::response()->setStatus(200)->setHeader("Location", '/usuarios');
        } catch (\Throwable|RequestException $e) {
            $status = $e instanceof RequestException ? $e->getCode() : 500;
            $_SESSION['error'] = $e->getMessage();
            $response = Response::response()->setStatus($status)->setHeader("Location", "/usuarios");
        }

        return $response;
    }

    public static function form(Request $request, Connection $connection): Response
    {

        $page = <<<HTML
<form action="/usuarios" method="POST" enctype="application/x-www-form-urlencoded">

<label for="name">Nome</label>
    <input type="text" name="name" id="name">

<label for="email">E-mail.</label>
<input type="email" name="email" id="email">

<input type="submit" value="Salvar">
</form>
HTML;

        return Response::response()->setStatus(200)->setBody($page);

    }

    /**
     * @throws \HttpException
     * @throws \Throwable
     */
    public static function delete(Request $request, Connection $connection): Response
    {
        $id = $request->get("id", false);

        if (empty($id)) {
            throw new RequestException("Nenhum usuário informado!", 422);
        }
        $model = new UsuariosModel($connection);
        $model->delete($id);

        $_SESSION['message'] = "Usuário removido com sucesso.";
        return Response::response()->setStatus(200)->setHeader("Location", "/usuarios");

    }

    /**
     * @throws \HttpException
     * @throws \Throwable
     */
    public static function put(Request $request, Connection $connection)
    {

        $id = $request->get("id", false);
        $nome = $request->post("name", false);
        $email = $request->post("email", false);

        if (empty($id)) {
            throw new RequestException("Nenhum usuário informado!", 422);
        }


        $updateData = ["name" => $nome, "email" => $email];
        $updateData = array_filter($updateData);
        if (empty($updateData)) {
            throw new RequestException("Nenhum dado informado para atualizar o registro!", 422);
        }

        $model = new UsuariosModel($connection);
        $model->update($id, $updateData);

        $_SESSION['message'] = "Usuário atualizado com sucesso.";
        return Response::response()->setStatus(200)->setHeader("Location", "/usuarios");
    }

}