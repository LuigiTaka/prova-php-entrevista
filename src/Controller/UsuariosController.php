<?php

namespace TestePratico\Controller;

use TestePratico\Connection;
use TestePratico\Exceptions\RequestException;
use TestePratico\Models\UsuariosModel;
use TestePratico\Request;
use TestePratico\Response;
use TestePratico\Template;

class UsuariosController
{


    /**
     * @param Request $request
     * @param Connection $connection
     * @return Response
     * @throws \Exception
     */
    public static function get(Request $request, Connection $connection): Response
    {
        $users = $connection->query("SELECT * FROM users");
        $errorMessage = $_SESSION['error'] ?? false;
        $message = $_SESSION['message'] ?? false;
        unset($_SESSION['error']);
        unset($_SESSION['message']);
        $page = new Template("usuarios");
        $page->set("users", $users);
        $page->set("errorMessage", $errorMessage);
        $page->set("message", $message);
        $page = $page->render();
        return Response::response()->setStatus(200)->setBody($page);
    }

    /**
     * @throws \Throwable
     */
    public static function post(Request $request, Connection $connection): Response
    {
        $nome = $request->post("name");
        $email = $request->post("email");
        $id = $request->post("id", false);

        if (!empty($id) && ctype_digit($id)) {
            $request->setGet(['id' => $id]);
            return self::put($request, $connection);
        }

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
        $model = new UsuariosModel($connection);
        $page = new Template("usuario_form");
        if (!empty($request->get("id")) && ctype_digit($request->get("id"))) {
            $usuario = $model->id($request->get("id"));
            $page->set('name', $usuario['name']);
            $page->set('email', $usuario['email']);
            $page->set("id", $usuario['id']);
        }

        return Response::response()->setStatus(200)->setBody($page->render());

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
    public static function put(Request $request, Connection $connection): Response
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