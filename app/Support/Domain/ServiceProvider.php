<?php

namespace Support\Domain;

use Support\Common\Traits\{
    LoadCommands,
    ComponentPath,
    ProviderRegisterProviders,
    ProviderRegisterTranslations
};
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

abstract class ServiceProvider extends LaravelServiceProvider
{
    use LoadCommands;
    use ComponentPath;
    use ProviderRegisterProviders;
    use ProviderRegisterTranslations;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslations();

        $this->loadCommands();
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSubProviders(collect($this->subProviders));
    }
}
