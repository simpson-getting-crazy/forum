<?php

namespace App\Http\Filters\Thread;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class FilterByCategory
{
    public function __construct(protected Request $request) {}

    public function handle(Builder $builder, \Closure $next): Builder
    {
        return $next($builder)
            ->when($this->request->get('category') != '0' && $this->request->has('category'), function ($query) {
                $query->whereHas('category', function ($q) {
                    return $q->where('slug', $this->request->get('category'));
                });
            });
    }
}

