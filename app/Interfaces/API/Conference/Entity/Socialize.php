<?php

namespace App\API\Conference\Entity;

use Ds\Set;
use Ds\Vector;
use Carbon\Carbon;
use App\API\Conference\Entity\Concerns\StartTime;
use App\API\Conference\Contracts\SocializeInterface;

final class Socialize implements SocializeInterface
{
    use StartTime;

    private string $name;
    private Carbon $startTime;

    public function __construct(string $name, int $startTimeInHours)
    {
        $this->name = $name;
        $this->startTime = Carbon::now()->startOfDay()->addHours($startTimeInHours);
    }

    public function startTime(): Carbon
    {
        return $this->startTime;
    }

    public function name(): string
    {
        return $this->name;
    }
}
