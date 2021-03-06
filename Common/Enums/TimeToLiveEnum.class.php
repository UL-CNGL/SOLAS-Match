<?php

namespace SolasMatch\Common\Enums;

class TimeToLiveEnum
{
    const SECOND        = 1;
    const MINUTE        = 60;
    const FIVE_MINUTES  = 300;
    const QUARTER_HOUR  = 900;
    const HALF_HOUR     = 1800;
    const HOUR          = 3600;
    const HALF_DAY      = 43200;
    const DAY           = 86400;
    const WEEK          = 604800; // 7 Days
    const MONTH         = 2592000; // 30 Days
}
