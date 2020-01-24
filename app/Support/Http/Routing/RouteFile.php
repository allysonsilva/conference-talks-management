<?php

namespace Support\Http\Routing;

use Illuminate\Routing\Router;
use Illuminate\Routing\RouteRegistrar;

abstract class RouteFile
{
    /**
     * @var array
     */
    private $options;

    /**
     * @var \Illuminate\Routing\Router|\Illuminate\Routing\RouteRegistrar
     */
    private $router;

    public function __construct(array $options = [])
    {
        $this->router = app(Router::class);

        $this->options = $options;
    }

    /**
     * @SuppressWarnings(PHPMD.ElseExpression)
     *
     * @return void
     */
    public function registerRouteGroups(): void
    {
        if ($this->router instanceof RouteRegistrar) {
            $this->router->group(function ($router) {
                $this->routes($router);
            });
        } else {
            // @codeCoverageIgnoreStart
            $this->router->group($this->options, function ($router) {
                $this->routes($router);
            });
            // @codeCoverageIgnoreEnd
        }
    }

    abstract protected function routes(Router $router): void;

    /**
     * Dynamically handle calls into the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     *
     * @return $this
     */
    public function __call(string $method, array $parameters): self
    {
        $this->router = call_user_func_array([$this->router, $method], $parameters);

        return $this;
    }
}
