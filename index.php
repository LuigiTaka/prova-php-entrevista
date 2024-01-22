<?php

use TestePratico\Connection;
use TestePratico\Controller\HomePageController;
use TestePratico\Controller\UsuariosController;
use TestePratico\Router;

require_once __DIR__ . "/autoload.php";

// Exemplo de uso

$router = new Router();

$connection = new Connection();

$router->get('/', function () {
    HomePageController::get(new \TestePratico\Request())->send();

});

$router->get('/usuarios', function () use ($connection) {

    $response = UsuariosController::get(new \TestePratico\Request(), $connection);
    $response->send();
});

$router->get('/usuarios/{id}', function ($id) {
    echo "Detalhes do usuário com ID: $id (GET)";
});

$router->post("/usuarios", function ($dados) {
    $response = new \TestePratico\Response("", 404);
    $response->send();
});

$router->put("/usuarios/{id}", function ($id, $dados) {
    $response = new \TestePratico\Response("", 404);
});

$router->executar();