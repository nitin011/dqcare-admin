<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

trait HasPagination
{
    public function scopePaginated(Builder $builder)
    {
        $page = request()->has('page') ? request()->get('page') : 1;
        $limit = request()->has('limit') ? request()->get('limit') : 10;

        return $builder->limit($limit)->offset(($page - 1) * $limit);
    }
}
