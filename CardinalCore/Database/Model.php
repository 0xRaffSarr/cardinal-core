<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database;

use CardinalCore\Database\Traits\ModelActions;
use CardinalCore\Database\Contracts\Model as ModelContracts;

abstract class Model implements ModelContracts
{
    use ModelActions;

    /**
     * The primary key name
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Primary key type
     *
     * @var string
     */
    protected $primaryKeyType = 'int';

    /**
     * fillable attributes of the model
     *
     * @var array
     */
    protected $fillable = [];

    protected bool $time = true;

    /**
     * The name of the "created at" column.
     *
     * @var string|null
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = 'updated_at';

    public function __construct() {
        $this->loadAttributes();
    }

    /**
     * Load the model attributes and set it to null
     */
    protected function loadAttributes() {
        foreach ($this->getModelAttributes() as $key) {
            $this->{$key} = null;
        }
    }

    /**
     * Return the model default attributes
     *
     * @return array
     */
    protected function getModelAttributes(): array {
        $attributes = [];

        if($this->time) {
            $attributes = array_merge([
                static::CREATED_AT,
                static::UPDATED_AT
            ]);
        }

        $attributes = array_merge($attributes, $this->fillable);

        return array_unique($attributes);
    }
}
