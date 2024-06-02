<?php

namespace App\BulkActions;

class MentionProcess
{
    public static function execute(array|int|string $mentionsId, string $content)
    {
        if (is_array($mentionsId)) {
            //
        } else {
            //
        }

        dd(json_decode($mentionsId));
    }
}
