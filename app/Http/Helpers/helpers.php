<?php

use Carbon\Carbon;


function dateTimeConverter($datetime)
{
    $datetime = Carbon::parse($datetime);
    return $datetime->format('Y-m-d h:i:s A');
}
