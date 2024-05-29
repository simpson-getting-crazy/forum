<?php

namespace App\Http\Filters\Thread;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByMostActive
{
    public function __construct(protected Request $request) {}

    public function handle(Builder $builder, \Closure $next): Builder
    {
        return $next($builder)
            ->when($this->request->get('tabFilter') == 'mostActive',
                fn ($query) => $query->orderBy('replies', 'desc')
        );
    }
}
