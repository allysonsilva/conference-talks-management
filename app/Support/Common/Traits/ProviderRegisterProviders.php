<?php

namespace Support\Common\Traits;

use Illuminate\Support\Collection;

trait ProviderRegisterProviders
{
    /**
     * List service providers to register.
     *
     * @var array
     */
    protected $subProviders = [];

    /**
     * Register the service providers.
     *
     * @param \Illuminate\Support\Collection $subProviders
     *
     * @return void
     */
    protected function registerSubProviders(Collection $subProviders): void
    {
        // loop through providers to be registered
        $subProviders->each(function ($providerClass) {
            // register a provider class
            $this->app->register($providerClass);
        });
    }
}
