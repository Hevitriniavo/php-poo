<?php

namespace Framework\Router;

/**
 * Class Route
 * Represent a matched route
 */
class Route {

    private string $name;
    /**
     * @var callable
     */
    private $callback;
    private array $parameters;

    public function __construct(string $name, callable $callback, array $parameters)
    {

        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

    /**
     *
     * @return string
     */
    public function getName(): string
    {
      return $this->name;
    }

    /**
     * @return callable
     */
    public function getCallable(): callable
    {
      return $this->callback;
    }

    /**
     *Retrieve the URL parameters
     * @return string[]
     */
    public function getParams(): array
    {
       return $this->parameters;
    }
}