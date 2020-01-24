<?php

namespace App\API\Conference\Contracts;

use Carbon\Carbon;

interface SocializeInterface
{
    public function name(): string;
    public function startTime(): Carbon;
}
