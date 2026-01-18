<?php

declare(strict_types=1);

namespace SellNow\Core;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container) {}

    /**
     * @Route("GET", path)
     */
    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * @Route("POST", path)
     */
    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    /**
     * @Route("PUT", path)
     */
    public function put(string $path, array $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    /**
     * @Route("PATCH", path)
     */
    public function patch(string $path, array $handler): void
    {
        $this->routes['PATCH'][$path] = $handler;
    }

    /**
     * @Route("DELETE", path)
     */
    public function delete(string $path, array $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    /**
     * @param Request $request
     */
    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path   = $request->path();

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $action] = $this->routes[$method][$path];
        $instance = $this->container->get($controller);

        $instance->$action($request);
    }
}
