<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'threads';

    protected $guarded = ['id'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parents(): HasMany
    {
        return $this->hasMany(Thread::class, 'parent_id', 'id')
            ->whereNotNull('parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUsersByLastActivityForThreads(): Collection
    {
        return $this->parents()
            ->orderBy('last_activity', 'desc')
            ->limit(3)
            ->get();
    }
}
