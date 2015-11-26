<?php

namespace Collections;

use SoftUni\Models\Usersession;

class UsersessionCollection
{
    /**
     * @var Usersession[];
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