<?php

namespace ConferenceDomain\DataObjects;

use Illuminate\Http\Request;
use Spatie\DataTransferObject\DataTransferObject;

class ConferenceData extends DataTransferObject
{
    public string $trackName;

    public string $trackMinutes;
}
