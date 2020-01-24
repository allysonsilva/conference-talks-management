<?php

namespace App\API\Conference\Entity;

use Ds\Vector;
use Traversable;
use App\API\Conference\Entity\Socialize;
use App\API\Conference\Contracts\SocializeInterface;

final class Track
{
    /**
     * @var Vector<\App\API\Conference\Entity\Session|\App\API\Conference\Entity\Socialize>
     */
    private Vector $sessions;

    private int $trackId;

    public function __construct(int $trackId)
    {
        $this->sessions = new Vector();

        $this->trackId = $trackId;
    }

    public function sessions(): Vector
    {
        return $this->sessions;
    }

    public function trackId(): int
    {
        return $this->trackId;
    }

    public function addSession(Session $session): void
    {
        $this->sessions->push($session);
    }

    public function addSocializingEvents(Socialize $socialize): void
    {
        $this->sessions->push($socialize);
    }

    public function populateData(array &$data): void
    {
        $data['title'] = "Track {$this->trackId()}";

        /** @var \Ds\Set<\App\API\Conference\Entity\Session|\App\API\Conference\Entity\Socialize> */
        $sessions = $this->sessions();

        foreach ($sessions as $session) {
            if ($session instanceof Socialize) {
                $data['talks'][] = "{$session->startTimeHuman()} {$session->name()}";
                continue;
            }

            foreach ($session->talks() as $talk) {
                $data['talks'][] = "{$talk->startTimeHuman()} {$talk->title()}";
            }
        }
    }
}
