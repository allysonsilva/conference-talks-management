<?php

namespace ConferenceDomain\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
        $this->registerFactories();
        $this->registerConstants();
        $this->registerMiddlewares();
        $this->registerRepositories();
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    private function registerFactories(): void
    {
        // if (! app()->environment('production')) {
        //     app(Factory::class)->load(__DIR__ . '/../Database/factories');
        // }
    }

    /**
     * Register an additional directory of constants.
     *
     * @SuppressWarnings("StaticAccess")
     *
     * @return void
     */
    private function registerConstants(): void
    {
        $files = Arr::wrap(glob(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Constants/*.php'));

        foreach ($files as $filename) {
            if (file_exists($filename) && strpos($filename, '.php') !== false) {
                require_once $filename;
            }
        }
    }

    /**
     * Register any middlewares services.
     *
     * @return void
     */
    private function registerMiddlewares(): void
    {
        // $this->app->router->aliasMiddleware('permissionAdmin', \ConferenceDomain\Http\Middleware\PermissionAdmin::class);
    }

    /**
     * Register any repositories services.
     *
     * @return void
     */
    public function registerRepositories(): void
    {
        // $this->app->bind(
        //     Contracts\PermissionRepository::class,
        //     Repositories\PermissionRepository::class
        // );

        // $this->app->bind(
        //     Contracts\RoleRepository::class,
        //     Repositories\RoleRepository::class
        // );
    }

    /**
     * Register any domain services.
     *
     * @return void
     */
    public function registerServices(): void
    {
        // $this->app->bind(
        //     Contracts\ProductService::class,
        //     Services\ProductService::class
        // );
    }
}
