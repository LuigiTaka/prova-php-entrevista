<?php

namespace TestePratico;

class Response
{
    protected array $headers = [];

    public function __construct(protected string $body = "", protected int $statusCode = 200)
    {
        $this->setStatus($statusCode)->setBody($body);
    }

    public function setStatus($statusCode): static
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($name, $value): static
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function setBody($body): static
    {
        $this->body = $body;
        return $this;
    }

    public function send(): void
    {
        // Configurar cabeçalhos
        http_response_code($this->statusCode);
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Enviar corpo da resposta
        echo $this->body;
    }

    static public function response(): Response
    {
        return new Response();
    }
}
