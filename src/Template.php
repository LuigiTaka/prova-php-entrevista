<?php

namespace TestePratico;

class Template
{
    const TEMPLATE_PATH = __DIR__ . "/../templates";

    protected array $vars = [];
    protected string $templateFile;

    public function __construct($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function set($name, $value): void
    {
        $this->vars[$name] = $value;
    }

    private function getTemplateFilepath()
    {
        return self::TEMPLATE_PATH . DIRECTORY_SEPARATOR . $this->templateFile . ".php";
    }

    /**
     * @throws \Exception
     */
    public function render(): bool|string
    {
        if (!file_exists($this->getTemplateFilepath())) {
            throw new \Exception("O arquivo de template '{$this->templateFile}' não existe.");
        }

        ob_start();
        extract($this->vars);
        include $this->getTemplateFilepath();
        return ob_get_clean();
    }

    /**
     * @throws \Exception
     */
    public function __toString(): string
    {
        echo $this->render();
    }
}
