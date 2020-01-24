<?php

namespace App\API\Conference\Entity;

use Ds\Set;
use Ds\Vector;
use Carbon\Carbon;
use App\API\Conference\Entity\Concerns\StartTime;

final class Session
{
    use StartTime;

    /**
     * @var Set<\App\API\Conference\Entity\Talk>
     */
    private Set $talks;

    private int $remainingDuration;

    private Carbon $startTime;

    public function __construct(int $durationInMinutes, int $startTimeInHours)
    {
        $this->talks = new Set();
        $this->startTime = Carbon::now()->startOfDay()->addHours($startTimeInHours);
        $this->remainingDuration = $durationInMinutes;
    }

    public function startTime(): Carbon
    {
        return $this->startTime;
    }

    public function talks(): Set
    {
        return $this->talks;
    }

    public function addTalk(Talk $talk): void
    {
        $this->talks->add($talk);

        $this->remainingDuration -= $talk->durationInMinutes();
    }

    /**
     * Verificar se a sessão tem espaço em minutos para
     * os minutos da TALK em questão.
     *
     * @param \App\API\Conference\Entity\Talk $talk
     *
     * @return bool
     */
    public function hasRoomFor(Talk $talk): bool
    {
        return $this->remainingDuration >= $talk->durationInMinutes();
    }
}
