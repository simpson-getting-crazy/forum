<?php

namespace App\BulkActions;

use Laravolt\Avatar\Avatar;

class GenerateAvatar
{
    public static function make(string $name, string $fullPath, int $quality = 100)
    {
        $avatar = new Avatar();
        $avatar
            ->create($name)
            ->setBackground('#FF7D29')
            ->setForeground('#FEFFD2')
            ->save($fullPath, $quality);


        return url("forum/avatar/$name.png");
    }
}
