<?php

namespace App\API;

use Illuminate\Support\AggregateServiceProvider;
use App\API\Conference\Providers\ConferenceInterfaceServiceProvider;

final class InterfaceAPIServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ConferenceInterfaceServiceProvider::class
    ];
}
