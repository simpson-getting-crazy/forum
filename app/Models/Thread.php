<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Thread extends Model
{
    use HasFactory;

    protected $table = 'threads';

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        $uniqueCode = Str::lower(Str::random(4));

        static::creating(function ($item) use ($uniqueCode) {
            $item->slug = empty($item->slug)
                ? Str::slug($item->title.' '.$uniqueCode)
                : Str::slug($item->slug.' '.$uniqueCode);
        });

        static::updating(function ($item) use ($uniqueCode) {
            $item->slug ??= Str::slug($item->title.' '.$uniqueCode);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function parents(): HasMany
    {
        return $this->hasMany(Thread::class, 'parent_id', 'id')
            ->whereNotNull('parent_id')
            ->whereNull('other_thread_replies');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Thread::class, 'parent_id', 'id')
            ->whereNotNull('parent_id')
            ->whereNull('other_thread_replies');
    }

    public function otherThreadReplies(): HasMany
    {
        return $this->hasMany(Thread::class, 'other_thread_replies', 'id')
            ->whereNull('parent_id')
            ->whereNotNull('other_thread_replies');
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

    public function mentions(): HasMany
    {
        return $this->hasMany(Mention::class);
    }

    public function votedThread(): HasOne
    {
        return $this->hasOne(VotedThread::class);
    }

    public function bookmarkedThread(): HasOne
    {
        return $this->hasOne(BookmarkedThread::class, 'thread_id', 'id');
    }

    public function checkIfBookmarked(): bool
    {
        if ($this->bookmarkedThread()->count() > 0 && Auth::check()) {
            return $this->bookmarkedThread->user_id == Auth::id();
        }

        return false;
    }

    public function checkIfVoted(string $type = null): bool
    {
        if ($this->votedThread()->count() > 0 && Auth::check()) {
            if (!is_null($type)) {
                return $this->votedThread->user_id == Auth::id() && $this->votedThread->type == $type;
            }

            return $this->votedThread->user_id == Auth::id();
        }

        return false;
    }
}
