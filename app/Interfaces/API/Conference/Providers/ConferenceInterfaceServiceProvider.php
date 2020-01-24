<?php

namespace App\API\Conference\Providers;

use Support\Interfaces\ServiceProvider;
use App\API\Conference\Rules\TalkTitleRule;

class ConferenceInterfaceServiceProvider extends ServiceProvider
{
    // protected string $viewsAlias = 'conference';

    // protected bool $hasViews = true;

    /**
     * @var array
     */
    protected $subProviders = [
        RouteServiceProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        \Illuminate\Validation\Rule::macro('talks', function () {
            return new TalkTitleRule();
        });
    }
}
