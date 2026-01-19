<?php

declare(strict_types=1);

namespace SellNow\Core;

use SellNow\Core\Security\Csrf;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container) {}

    /**
     * @Route("GET", path)
     */
    public function get(string $path, array $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    /**
     * @Route("POST", path)
     */
    public function post(string $path, array $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    /**
     * @Route("PUT", path)
     */
    public function put(string $path, array $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    /**
     * @Route("PATCH", path)
     */
    public function patch(string $path, array $handler): void
    {
        $this->addRoute('PATCH', $path, $handler);
    }

    /**
     * @Route("DELETE", path)
     */
    public function delete(string $path, array $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    /**
     * Add route to routes array.
     */
    protected function addRoute(string $method, string $path, array $handler): void
    {
        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
        ];
    }

    /**
     * Dispatch request to the correct controller.
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path   = $request->path();

        if (!isset($this->routes[$method])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        if (in_array($method, ['POST','DELETE'], true) && !Csrf::validate($request->input('_csrf'))) {
            http_response_code(419);
            echo "Invalid CSRF token";
            return;
        }

        foreach ($this->routes[$method] as $route) {
            $pattern = $this->convertPathToRegex($route['path']);

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches); // remove full match

                [$controller, $action] = $route['handler'];
                $instance = $this->container->get($controller);

                // Pass request + route parameters
                $instance->$action($request, ...$matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    /**
     * Convert path to regex.
     */
    protected function convertPathToRegex(string $path): string
    {
        $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}

