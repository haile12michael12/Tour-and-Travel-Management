<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private string $notFoundHandler = 'ErrorController@notFound';

    public function add(string $method, string $path, string $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler
        ];
    }

    public function get(string $path, string $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function setNotFoundHandler(string $handler): void
    {
        $this->notFoundHandler = $handler;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                $this->handleRoute($route['handler']);
                return;
            }
        }

        $this->handleRoute($this->notFoundHandler);
    }

    private function matchPath(string $routePath, string $requestPath): bool
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        foreach ($routeParts as $index => $routePart) {
            if (strpos($routePart, ':') === 0) {
                continue;
            }

            if ($routePart !== $requestParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private function handleRoute(string $handler): void
    {
        [$controller, $method] = explode('@', $handler);
        $controllerClass = "App\\Controllers\\{$controller}";
        
        if (!class_exists($controllerClass)) {
            throw new \Exception("Controller {$controller} not found");
        }

        $controllerInstance = new $controllerClass();
        
        if (!method_exists($controllerInstance, $method)) {
            throw new \Exception("Method {$method} not found in controller {$controller}");
        }

        $controllerInstance->$method();
    }
} 