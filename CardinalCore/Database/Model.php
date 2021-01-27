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
     * Table name of the database
     *
     * @var string
     */
    protected string $table;
    /**
     * Indicates whether the model exists within the database.
     *
     * @var bool
     */
    protected bool $exists = false;

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

    /**
     * Model constructor.
     */
    public function __construct() {
        // if table name is not set, get the table name based on model name
        if(!$this->table) {
            $this->table = $this->getTableName();
        }

        $this->loadAttributes();
    }

    /**
     * Return the table name
     *
     * @return string
     */
    public function tableName() {
        return $this->table;
    }

    /**
     * Return the primary key name
     *
     * @return string
     */
    public function primaryKey() {
        return $this->primaryKey;
    }

    /**
     * Return the primary key type
     *
     * @return string
     */
    public function primaryKeyType() {
        return $this->primaryKeyType;
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
        //generate model attributes
        $attributes = array_merge($attributes, $this->fillable);
        //duplicate attribute removal
        return array_unique($attributes);
    }

    /**
     * Get the table name based on model name
     *
     * @return string
     */
    private function getTableName() {
        $x = new \ReflectionClass($this);

        return strtolower($x->getShortName()).'s';
    }
}
