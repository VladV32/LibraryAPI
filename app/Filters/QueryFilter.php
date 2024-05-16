<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{
    protected Request $request;
    protected Builder $builder;
    protected string $delimiter = ',';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], [$value]);
            }
        }

        return $this->builder;
    }

    public function filters(): array|string|null
    {
        return $this->request->query();
    }

    protected function paramToArray($param): array
    {
        return explode($this->delimiter, $param);
    }
}
