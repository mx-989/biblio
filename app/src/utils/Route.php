<?php
namespace App\utils;

class Route
{
    private $method;
    private $pattern;
    private $callback;
    private $middlewares;

    public function __construct($method, $pattern, $callback, $middlewares = [])
    {
        $this->method = $method;
        $this->pattern = rtrim($pattern, '/');
        $this->callback = $callback;
        $this->middlewares = $middlewares;
    }

    public function match($method, $uri)
    {
        if ($method !== $this->method) {
            return false;
        }

        $uri = rtrim($uri, '/');
        $patternRegex = preg_replace('/\{[\w]+\}/', '([\w-]+)', $this->pattern);
        $patternRegex = '#^' . $patternRegex . '$#';

        return preg_match($patternRegex, $uri);
    }

    public function call()
    {
        $uri = rtrim($_SERVER['REQUEST_URI'], '/');
        $uri = explode('?', $uri)[0];

        $patternRegex = preg_replace('/\{[\w]+\}/', '([\w-]+)', $this->pattern);
        $patternRegex = '#^' . $patternRegex . '$#';

        preg_match($patternRegex, $uri, $matches);
        array_shift($matches);

        foreach ($this->middlewares as $middleware) {
            $instance = new $middleware;
            $instance->handle();
        }

        [$class, $method] = $this->callback;
        $controller = new $class;
        call_user_func_array([$controller, $method], $matches);
    }
}
