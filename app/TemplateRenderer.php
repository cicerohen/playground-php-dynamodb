<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class TemplateRenderer
{
    private $twig;

    public function __construct()
    {
        $htmlPath = __DIR__ . DIRECTORY_SEPARATOR . "templates";
        $loader = new FilesystemLoader($htmlPath);
        $this->twig = new Environment($loader);
    }

    public function render(string $template, array $data = [])
    {
        return $this->twig->render($template, $data);
    }
}
