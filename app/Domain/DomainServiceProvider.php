<?php

namespace Domain;

use Illuminate\Support\AggregateServiceProvider;
use ConferenceDomain\Providers\ConferenceDomainServiceProvider;

final class DomainServiceProvider extends AggregateServiceProvider
{
    /**
     * The provider class names.
     *
     * @var array
     */
    protected $providers = [
        ConferenceDomainServiceProvider::class
    ];
}
