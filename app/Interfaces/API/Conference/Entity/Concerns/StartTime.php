<?php

namespace App\API\Conference\Entity\Concerns;

use Carbon\Carbon;

trait StartTime
{
    /**
     * @SuppressWarnings("UnusedFormalParameter")
     *
     * @param mixed ...$params
     *
     * @return string
     */
    public function startTimeHuman(...$params): string
    {
        return $this->startTime()->format('h:iA');
    }
}
