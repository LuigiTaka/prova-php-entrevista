<?php

namespace TestePratico;


class Request
{
    protected array $get;
    protected array $post;
    protected mixed $method;
    protected string|array|int|null|false $path;
    protected array|false $headers;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->headers = getallheaders();
    }

    public function get($chave, $padrao = null)
    {
        return $this->get[$chave] ?? $padrao;
    }

    public function post($chave, $padrao = null)
    {
        return $this->post[$chave] ?? $padrao;
    }

    public function method()
    {
        return $this->method;
    }

    public function path(): bool|int|array|string|null
    {
        return $this->path;
    }

    public function header($chave, $padrao = null)
    {
        return $this->headers[$chave] ?? $padrao;
    }

    static public function request(): Request
    {
        return new Request();
    }

    public function setPost($dados): void
    {
        $this->post = $dados;
    }
}