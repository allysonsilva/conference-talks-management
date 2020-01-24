<?php

namespace ConferenceDomain\Providers;

use Support\Domain\ServiceProvider as DomainServiceProvider;

final class ConferenceDomainServiceProvider extends DomainServiceProvider
{
    protected string $translationAlias = 'conference';

    protected bool $hasTranslations = true;

    /**
     * @var array
     */
    protected $subProviders = [
        BindServiceProvider::class,
        AuthServiceProvider::class,
        EventServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
