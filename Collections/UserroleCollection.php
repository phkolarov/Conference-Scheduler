<?php

namespace Collections;

use SoftUni\Models\Userrole;

class UserroleCollection
{
    /**
     * @var Userrole[];
     */
    private $collection = [];

    public function __construct($models = [])
    {
        $this->collection = $models;
    }

    /**
     * @param callable $callback
     */
    public function each(Callable $callback)
    {
        foreach ($this->collection as $model) {
            $callback($model);
        }
    }
}