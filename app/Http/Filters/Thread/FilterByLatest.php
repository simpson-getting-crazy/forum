<?php

namespace App\Http\Filters\Thread;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByLatest
{
    public function __construct(protected Request $request) {}

    public function handle(Builder $builder, \Closure $next): Builder
    {
        return $next($builder)
            ->when($this->request->get('tabFilter') == 'latest',
                fn ($query) => $query->orderBy('created_at', 'desc')->orderBy('last_activity', 'desc')
        );
    }
}
