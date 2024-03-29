<?php

namespace App;

use Core\ConsoleKernel;
use App\API\InterfaceAPIServiceProvider;
use Illuminate\Support\AggregateServiceProvider;

final class InterfacesServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        InterfaceAPIServiceProvider::class
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        (app(ConsoleKernel::class))->loadCommandsForPaths(__DIR__ . DIRECTORY_SEPARATOR . ('Console' . DIRECTORY_SEPARATOR . 'Commands'));
    }
}
