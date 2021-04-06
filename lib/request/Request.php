<?php

declare(strict_types=1);

namespace framework\lib\request;


class Request
{
    private array $files;
    private array $server;
    private array $get;
    private array $post;
    private array $cookie;
    private $body;

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->get = $_GET;
        $this->post = $_POST;
        $this->cookie = $_COOKIE;
        $this->files = $_FILES;
        $this->body = file_get_contents('php://input');
    }

    public function body(): string
    {
        return $this->body;
    }

    public function get(string $paramName): ?string
    {
        if (!isset($this->get[$paramName])) {
            return null;
        }
        return $this->get[$paramName];
    }

    public function post(string $paramName): ?string
    {
        if (!isset($this->post[$paramName])) {
            return null;
        }
        return $this->post[$paramName];
    }

    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getMethod(): string
    {
        return $_SERVER["REQUEST_METHOD"];
    }
}