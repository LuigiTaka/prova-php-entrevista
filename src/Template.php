<?php

namespace TestePratico;

class Template
{
    const TEMPLATE_PATH = __DIR__ . "/../templates";

    protected array $vars = [];
    protected string $templateFile;
    protected array $scripts = [];
    protected array $styles = [];

    public function __construct($templateFile)
    {
        $this->templateFile = $templateFile;
    }

    public function set($name, $value): void
    {
        $this->vars[$name] = $value;
    }

    private function getTemplateFilepath(): string
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
        return $this->render();
    }

    public function js(string $path): void
    {
        $this->scripts[] = $path;
    }

    public function css(string $path): void
    {
        $this->styles[] = $path;
    }

    public function getStyles(): array
    {
        return $this->styles;
    }

    public function getJs()
    {
        return $this->scripts;
    }
}
