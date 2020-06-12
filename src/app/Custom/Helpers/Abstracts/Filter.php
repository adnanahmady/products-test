<?php

namespace App\Custom\Helpers\Abstracts;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter {
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * specified filters
     *
     * @var array
     */
    protected $filters = [];

    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * applies filters on query string
     * givin parameters
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $key => $value) {
            if ($value === null) continue;
            if (method_exists(
                $this,
                $method = $this->getMethodName($key)
            )) {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    /**
     * returns related method name
     * to filter key
     *
     * @param mixed $name
     */
    protected function getMethodName($name)
    {
        $words = explode('_', $name);

        return array_shift($words) . implode(
            '', 
            array_map(function ($word) {
                return ucfirst($word);
            }, $words)
        );
    }

    /**
     * returns an array of specified query string 
     * parameters if does exists on request
     * else returns an empty array
     *
     * @return array
     */
    public function getFilters(): array
    {
        return $this->request->only($this->filters);
    }
}
