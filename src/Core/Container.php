<?php

declare(strict_types=1);

namespace SellNow\Core;

use ReflectionClass;
use ReflectionNamedType;

class Container
{
    private array $bindings = [];

    /**
     * @param string $key
     * @param callable $resolver
     */
    public function bind(string $key, callable $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        // If explicitly bound, resolve via factory
        if (isset($this->bindings[$key])) {
            return $this->bindings[$key]($this);
        }

        // Autowire using reflection
        if (!class_exists($key)) {
            throw new \Exception("Class {$key} does not exist");
        }

        $reflection = new ReflectionClass($key);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $key;
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $param) {
            $type = $param->getType();

            if (!$type instanceof ReflectionNamedType) {
                throw new \Exception(
                    "Cannot resolve untyped parameter {$param->getName()}"
                );
            }

            $dependencies[] = $this->get($type->getName());
        }

        return $reflection->newInstanceArgs($dependencies);
    }
}
