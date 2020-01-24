<?php

namespace Support\Interfaces;

use Support\Common\Traits\{
    ComponentPath,
    ProviderRegisterProviders
};
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    use ComponentPath;
    use ProviderRegisterProviders;

    /**
     * Alias for views.
     *
     * @var string
     */
    protected string $viewsAlias;

    /**
     * Views resource path.
     *
     * @var string
     */
    protected string $viewsPath = 'Resources' . DIRECTORY_SEPARATOR . 'Views';

    /**
     * Enable views loading.
     *
     * @var bool
     */
    protected bool $hasViews = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerSubProviders(collect($this->subProviders));
    }

    /**
     * @codeCoverageIgnore
     *
     * @return void
     */
    protected function loadViews(): void
    {
        if ($this->hasViews) {
            $this->loadViewsFrom(
                $this->componentPath($this->viewsPath),
                $this->viewsAlias
            );
        }
    }
}
