<?php

namespace ConferenceDomain\Models;

use Support\ORM\BaseModel;
use ConferenceDomain\Models\Concerns\{
    ConferenceScope,
    ConferenceAccessor,
    ConferenceFunction,
    ConferenceRelationship
};

final class Conference extends BaseModel
{
    use ConferenceAccessor;
    use ConferenceRelationship;
    use ConferenceFunction;
    use ConferenceScope;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
