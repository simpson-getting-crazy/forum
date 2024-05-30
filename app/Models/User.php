<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function getRelatedUserLastPost(): string
    {
        $record = $this->threads()->latest()->first();

        return is_null($record)
            ? 'Not Posted Yet!'
            : 'Last Post '.\Carbon\Carbon::parse($record->created_at)->diffForHumans();

    }

    public function getUserJoinedAt(): string
    {
        return 'Joined at '.\Carbon\Carbon::parse($this->created_at)->format('M d, y');
    }

    public function getRelatedUserThreads(bool $withPagination = false): Collection|LengthAwarePaginator
    {
        return !$withPagination
            ? $this->threads()->whereNull('parent_id')->get()
            : $this->threads()->whereNull('parent_id')->paginate(5);
    }

    public function getRelatedUserPosts(): Collection
    {
        return $this->threads()->get();
    }
}
