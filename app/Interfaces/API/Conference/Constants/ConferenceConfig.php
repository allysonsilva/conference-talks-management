<?php

namespace App\API\Conference\Constants;

interface ConferenceConfig
{
    const TOTAL_TRACK_DURATION_MINUTES = 420;
    const MORNING_SESSION_DURATION_MINUTES = 180;
    const AFTERNOON_SESSION_DURATION_MINUTES = 240;

    const LUNCH_DURATION_MINUTES = 60;
    const NETWORKING_DURATION_MINUTES = 60;

    const TRACK_START_TIME = 9;
    const LUNCH_START_TIME = 12;
    const POST_LUNCH_SESSION_START_TIME = 13;
    const NETWORKING_START_TIME = 17;
}
