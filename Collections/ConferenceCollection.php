<?php

namespace Collections;

use SoftUni\Models\Conference;

class ConferenceCollection
{
    /**
     * @var Conference[];
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