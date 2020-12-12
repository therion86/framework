<?php

declare(strict_types=1);

namespace framework\templateEngine;

use framework\interfaces\TemplateEngineInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

/**
 * @author Therion86
 */
class TemplateEngine implements TemplateEngineInterface
{

    private string $template;

    private string $templatePath;

    private array $variables;

    /**
     * @author Therion86
     */
    public function __construct()
    {
        $this->variables = [];
        $this->template = '';
        $this->templatePath = '';
    }

    /**
     * @param string $paramName
     * @param mixed $value
     * @return void
     * @author Therion86
     */
    public function assign(string $paramName, $value): void
    {
        $this->variables[$paramName] = $value;
    }

    /**
     * @param string $templateName
     * @param string $module
     * @return void
     * @author Therion86
     */
    public function load(string $templateName, string $module): void
    {
        $this->templatePath = 'src/modules/' . $module . '/templates/';
        $this->template = $templateName . '.twig';
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @author Therion86
     */
    public function printTemplate(): string
    {
        $loader = new FilesystemLoader($this->templatePath);
        $twig = new Environment(
            $loader/*,
            ['cache' => '/templates_c']*/
        );
        $twig->load($this->template);
        return $this->appendToDefaultTemplate($twig->render($this->template, $this->variables), '');
    }

    /**
     * @param string $content
     * @param string $navigation
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @author Therion86
     */
    private function appendToDefaultTemplate(string $content, string $navigation): string
    {
        $loader = new FilesystemLoader('/');
        $twig = new Environment($loader);
        $twig->load('default.twig');
        $variables = [
            'content' => $content,
            'navigation' => $navigation
        ];
        return $twig->render('default.twig', $variables);
    }
}