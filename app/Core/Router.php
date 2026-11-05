<?php

declare(strict_types=1);

namespace App\Core;

use App\Controllers\ErrorController;

final class Router
{
    /**
     * @var array<int, array{method: string, pattern: string, action: array{0: class-string, 1: string}}>
     */
    private array $routes = [];

    /**
     * @param array{0: class-string, 1: string} $action
     */
    public function get(string $path, array $action): void
    {
        $this->add('GET', $path, $action);
    }

    /**
     * @param array{0: class-string, 1: string} $action
     */
    public function post(string $path, array $action): void
    {
        $this->add('POST', $path, $action);
    }

    /**
     * @param array{0: class-string, 1: string} $action
     */
    private function add(string $method, string $path, array $action): void
    {
        $this->routes[] = [
            'method' => $method,
            'pattern' => '/' . trim($path, '/'),
            'action' => $action,
        ];
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = '/' . trim(parse_url($uri, PHP_URL_PATH) ?: '/', '/');

        if ($method === 'HEAD') {
            $method = 'GET';
        }

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $params = $this->match($route['pattern'], $path);

            if ($params === null) {
                continue;
            }

            [$controller, $action] = $route['action'];
            (new $controller())->{$action}(...$params);

            return;
        }

        (new ErrorController())->notFound();
    }

    /**
     * @return array<int, string>|null
     */
    private function match(string $pattern, string $path): ?array
    {
        $regex = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array $matches): string => '(?P<' . $matches[1] . '>[^/]+)',
            str_replace('/', '\/', $pattern)
        );

        if ($regex === null || preg_match('#^' . $regex . '$#u', $path, $matches) !== 1) {
            return null;
        }

        return array_values(array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY));
    }
}
