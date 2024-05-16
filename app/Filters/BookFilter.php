<?php

namespace App\Filters;

use \Illuminate\Database\Eloquent\Builder;

class BookFilter extends QueryFilter
{
    protected function title(string $title): Builder
    {
        return $this->builder->whereRaw("MATCH(title) AGAINST(? IN BOOLEAN MODE)", [$title]);
    }
}