<?php

namespace TestePratico;

class Router
{
    private array $rotas = [];

    public function get($caminho, $callback): void
    {
        $this->adicionarRota($caminho, 'GET', $callback);
    }

    public function post($caminho, $callback): void
    {
        $this->adicionarRota($caminho, 'POST', $callback);
    }

    public function put($caminho, $callback): void
    {
        $this->adicionarRota($caminho, 'PUT', $callback);
    }

    public function delete($caminho, $callback): void
    {
        $this->adicionarRota($caminho, 'DELETE', $callback);
    }

    private function adicionarRota($caminho, $metodo, $callback): void
    {
        $this->rotas[] = [
            'caminho' => $caminho,
            'metodo' => $metodo,
            'callback' => $callback
        ];
    }

    /**
     * @return void
     */
    public function executar(): void
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = rtrim($url, '/');
        $url = ($url == '') ? '/' : $url;
        $metodo = $_SERVER['REQUEST_METHOD'];

        foreach ($this->rotas as $rota) {
            $padrao = str_replace('/', '\/', $rota['caminho']);
            $padrao = preg_replace('/{[a-zA-Z0-9_]+}/', '([a-zA-Z0-9_]+)', $padrao);
            $padrao = "/^{$padrao}$/";

            if ($rota['metodo'] == $metodo && preg_match($padrao, $url, $matches)) {
                array_shift($matches);
                $callback = $rota['callback'];

                // Se for POST ou PUT, processa o conteúdo da requisição
                if (isset(["PUT" => 1, 'POST' => 1][$metodo])) {
                    $dadosRequisicao = $this->parseDadosRequisicao();
                    /** @var array $dadosRequisicao */
                    call_user_func_array($callback, array_merge($matches, [$dadosRequisicao]));
                } else {
                    call_user_func($callback, ...$matches);
                }

                return;
            }
        }

        Response::response()->setStatus(404)->setBody("Página não encontrada")->send();
    }

    private function parseDadosRequisicao()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            return json_decode(file_get_contents("php://input"), true);
        } elseif ($contentType === "application/x-www-form-urlencoded") {
            return $_POST;
        } else {
            return [];
        }
    }

}


