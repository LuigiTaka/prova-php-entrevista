<?php

use TestePratico\Connection;
use TestePratico\Controller\HomePageController;
use TestePratico\Controller\UsuariosController;
use TestePratico\Router;

require_once __DIR__ . "/autoload.php";

// Exemplo de uso

$router = new Router();

$connection = new Connection();
session_start();

$router->get('/', function () {
    HomePageController::get(new \TestePratico\Request())->send();

});

$router->get('/usuarios', function () use ($connection) {

    $response = UsuariosController::get(new \TestePratico\Request(), $connection);
    $response->send();
});

$router->post("/usuarios", function ($dados) use($connection) {
    $request  = new \TestePratico\Request();
    $request->setPost( $dados );
    $response = UsuariosController::post( $request,  $connection);
    $response->send();
});

$router->delete("/usuarios/{id}", function ($id) use ($connection) {
    $request = new \TestePratico\Request();
    $request->setGet(['id' => $id]);
    $response = UsuariosController::delete($request,$connection);
    $response->send();
});

$router->get("/usuarios/novo",function () use ($connection){
    $response = UsuariosController::form(new \TestePratico\Request(), $connection);
    $response->send();
});
$router->get('/usuarios/{id}', function ($id) {
    echo "Detalhes do usuário com ID: $id (GET)";
});
$router->put("/usuarios/{id}", function ($id, $dados) {
    $response = new \TestePratico\Response("", 404);
});


try {
    $router->executar();
}catch (\Throwable $e){
    \TestePratico\Response::response()->setStatus(500)->setBody($e->getMessage())->send();
}