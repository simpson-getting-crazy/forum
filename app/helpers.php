<?php

use Illuminate\Support\Carbon;

function compactDiffForHumans($date): string
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

function getAspectRatio($width, $height): array
{
    function getDivisorList($px): array
    {
        $list = [];
        $i = 1;

        while($px / $i >= 1) {
            if ($px % $i === 0) {
                $div = $px / $i;
                $list[$div] = $px / $div;
            }
            $i++;
        }
        return $list;
    }

    $w = getDivisorList($width);
    $h = getDivisorList($height);

    $aspect = "";
    $ratio = 0;

    foreach ($w as $div => $num) {
        if (isset($h[$div])) {
            $aspect = $num . ":" . $h[$div];
            $ratio = $num / $h[$div];
            break;
        }
    }

    return ['aspect' => $aspect, 'ratio' => $ratio];
}

function summernotePlacement($content): string
{

    return str_replace('&nbsp;', ' ', strip_tags($content));
}
