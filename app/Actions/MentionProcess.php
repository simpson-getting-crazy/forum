<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

class MentionProcess
{
    public static function execute(array|int|string $mentionsId, Model $thread)
    {
        $mentionsId = json_decode($mentionsId);

        if (is_array($mentionsId)) {
            foreach($mentionsId as $mentionId) {
                $thread->mentions()->create([
                    'author' => $thread->user->id,
                    'mentioned_user' => $mentionId
                ]);
            }
        } else {
            $thread->mentions()->create([
                'author' => $thread->user->id,
                'mentioned_user' => $mentionsId
            ]);
        }

        return (object) [
            'value' => $thread,
        ];
    }
}
