<?php

namespace App\API\Conference\ValueObjects;

use App\API\Conference\Entity\Talk;

final class TalksCompare
{
    public function __invoke(Talk $current, Talk $compare): int
    {
        if ($compare->durationInMinutes() === $current->durationInMinutes()) {
            return $current->title() <=> $compare->title();
        }

        return $compare->durationInMinutes() <=> $current->durationInMinutes();
    }
}
