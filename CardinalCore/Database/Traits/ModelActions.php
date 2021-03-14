<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Traits;

use Carbon\Carbon;
use CardinalCore\Database\Database;
use CardinalCore\Database\Exception\DatabaseException;
use CardinalCore\Database\Exception\ModelException;
use CardinalCore\Database\Exception\ModelNotFoundException;
use CardinalCore\Database\Model;

trait ModelActions
{
    /**
     * Delete the model information. If the model not exists into the database, throws an
     * ModelException and not delete it.
     *
     * @return bool
     *
     * @throws ModelException
     */
    public function delete () {
        //if model not exist in database, cannot delete it
        if(!$this->exists) {
            throw new ModelException(get_class().' not exists into database. Cannot delete it');
        }

        $stmt = Database::connection()->prepare('DELETE FROM '.$this->tableName() .' WHERE '.$this->primaryKey().' = :keyValue');
        $stmt->bindParam(':keyValue', $this->{$this->primaryKey()});

        return Database::exec($stmt);
    }

    /**
     * Create the model object
     *
     * @param array $values The values of the model.
     *
     * @param bool $save Determines whether to save the model in the database. If save is set to true, the model is
     *                   saved in the database, otherwise it is not saved in database.
     *                   By default, save is set to true.
     *
     * @return Model     Return an instance of model.
     *
     * @throws DatabaseException
     */
    public static function create(array $values, bool $save = true) {
        $modelObj = new static();

        $modelObj->setAttributes($values);

        //If the saved is set to true, the model is saved in databse
        if($save) {
            if(!$modelObj->save()) {
                throw new DatabaseException('Cannot save the data');
            }
            else {
                $modelObj->exists = true;
            }
        }

        return $modelObj;
    }

    /**
     * Find a model in database. If model exists return it, otherwise return null.
     *
     * @param $key  The primary key value of the model
     *
     * @return static|null
     */
    public static function find($key) {

        $model = new static();

        $query = "SELECT * FROM `$model->table` WHERE $model->primaryKey = :".$model->primaryKey()."Val";

        $stmt = Database::connection()->prepare($query);

        $stmt->bindParam(":".$model->primaryKey()."Val", $key);

        $exec = Database::exec($stmt);

        if($exec && $stmt->rowCount() > 0) {
            $data = $stmt->fetch();

            $model->{$model->primaryKey()} = $data[$model->primaryKey()];
            $model->exists = true;

            foreach ($model->getModelAttributes() as $attribute) {
                $model->{$attribute} = $data[$attribute];
            }
        }
        else {
            $model = null;
        }

        return $model;
    }

    /**
     * Find a model in database. If model exists return it, otherwise throw a Model Exception.
     *
     * @param $key The primary key value of the model
     *
     * @return ModelActions|null
     *
     * @throws ModelException
     */
    public static function findOrFail($key) {
        $result = static::find($key);

        if(is_null($result)) {
            throw new ModelNotFoundException();
        }

        return $result;
    }

    /**
     * Updates the model information and saves it in the database. If the model not exists into the database, throws an
     * ModelException and not update it.
     *
     * @param array $values The values of the model.
     * @return bool
     * @throws ModelException
     */
    public function update(array $values) {

        //If model not exist in database, cannot execute update
        if(!$this->exists) {
            throw new ModelException(get_class().' not exists into database. Cannot update it');
        }

        $this->setAttributes($values);

        return $this->save();
    }

    /**
     * Save the model in database. If model not exists it execute a CREATE query. If the model exists in database, it
     * execute an UPDATE query.
     *
     * @return bool return true if it successful, false otherwise.
     */
    public function save(): bool {

        $attributeList = '';
        $attributeKey = '';

        $this->getAttributesListKey($attributeList, $attributeKey, $this->exists);

        //If the model not exist into the database, execute an insert query
        //else if the model exists, execute an update query
        if(!$this->exists) {
            $query = "INSERT INTO `$this->table`($attributeList) VALUES ($attributeKey)";
        }
        else {
            $query = "UPDATE `$this->table` SET ".$attributeList." WHERE ".$this->primaryKey()." = ".$this->{$this->primaryKey()};
        }

        //set the time of model save. If the model exists set only the update time, otherwise set the created time also
        $this->setTime(!$this->exists);

        $stmt = Database::connection()->prepare($query);

        //binding parameter
        foreach ($this->getModelAttributes() as $attribute) {
            $stmt->bindParam(':'.$attribute.'Val', $this->{$attribute});
        }

        return Database::exec($stmt);
    }

    /**
     * Set the model time if the model's time attributes is true
     *
     * @param bool $created if true set the created time field to actual time.
     */
    protected function setTime(bool $created = false) {
        if($this->time) {

            $actualTime = new Carbon('now');

            if($created) {
                $this->{static::CREATED_AT} = $actualTime;
            }

            $this->{static::UPDATED_AT} = $actualTime;
        }
    }

    /**
     *
     *
     * @param $attributesList
     * @param $attributesKey
     * @param bool $setMode
     */
    protected function getAttributesListKey(&$attributesList, &$attributesKey, bool $setMode = false) {
        $first = true;

        foreach ($this->getModelAttributes() as $attribute) {

            //load the list of attribute to add
            //if is the first attribute does not precede the comma

            if($setMode){
                $attributesList .= ((!$first) ? ', ' : '').$attribute." = ".':'.$attribute.'Val';
            }
            else {
                $attributesList .= ((!$first) ? ', ' : '').$attribute;
            }
            //load the key of the value
            //if is the first attribute does not precede the comma
            $attributesKey .= ((!$first) ? ', ' : '').':'.$attribute.'Val';
            //set to false, after first iteration
            $first = false;
        }
    }
}
