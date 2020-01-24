<?php

namespace App\API\Conference\Entity;

use Ds\Vector;

final class Conference
{
    /**
     * @var Vector<\App\API\Conference\Entity\Track>
     */
    private Vector $tracks;

    public function __construct()
    {
        $this->tracks = new Vector();
    }

    public function tracks(): Vector
    {
        return $this->tracks;
    }

    public function addTrack(Track $track): void
    {
        $this->tracks->push($track);
    }
}
