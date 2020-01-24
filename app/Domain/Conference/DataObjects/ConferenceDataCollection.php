<?php

namespace ConferenceDomain\DataObjects;

use Spatie\DataTransferObject\DataTransferObjectCollection;

class ConferenceDataCollection extends DataTransferObjectCollection
{
    public function current(): ConferenceData
    {
        return parent::current();
    }
}
