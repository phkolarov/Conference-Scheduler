<?php

namespace Collections;

use \IdentitySystem\IdentityModels\IdentitySessionModel;


class SessionCollection
{
    /**
     * @var Building[];
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