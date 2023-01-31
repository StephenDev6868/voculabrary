<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Filterable
{
    public function scopeFilter($query, $param)
    {
        foreach ($param as $field => $value) {
            if (empty($value)) {
                continue;
            }

            $method = 'filter' . Str::studly($field);

            if (method_exists($this, $method)) {
                $this->{$method}($query, $value);
                continue;
            }

            if (empty($this->filterable) || !is_array($this->filterable)) {
                continue;
            }

            if (in_array($field, $this->filterable)) {
                $query->where($field, $value);
                continue;
            }

            if (key_exists($field, $this->filterable)) {
                $query->where($this->filterable[$field], $value);
                continue;
            }
        }

        return $query;
    }
}
