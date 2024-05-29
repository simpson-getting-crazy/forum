<?php

use Illuminate\Support\Carbon;

function compactDiffForHumans($date)
{
    $date = Carbon::parse($date);
    $now = Carbon::now();

    $diffInSeconds = $date->diffInSeconds($now);
    $diffInMinutes = $date->diffInMinutes($now);
    $diffInHours = $date->diffInHours($now);
    $diffInDays = $date->diffInDays($now);
    $diffInMonths = $date->diffInMonths($now);
    $diffInYears = $date->diffInYears($now);

    if ($diffInSeconds < 60) {
        return $diffInSeconds . 's';
    } elseif ($diffInMinutes < 60) {
        return $diffInMinutes . 'min';
    } elseif ($diffInHours < 24) {
        return $diffInHours . 'h';
    } elseif ($diffInDays < 30) {
        return $diffInDays . 'd';
    } elseif ($diffInMonths < 12) {
        return $diffInMonths . 'mo';
    } else {
        return $diffInYears . 'y';
    }
}
