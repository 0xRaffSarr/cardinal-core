<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Traits;

use CardinalCore\Database\Database;
use CardinalCore\Database\Model;

trait ModelActions
{
    /**
     * Delete the model information
     */
    public function delete () {
        $stmt = Database::connection()->prepare('DELETE FROM '.$this->tableName() .' WHERE '.$this->primaryKey().' = :keyValue');
        $stmt->bindParam(':keyValue', $this->{$this->primaryKey()});

        return Database::exec($stmt);
    }

    /**
     * Create the model object
     *
     * @param array $values The values of the array.
     *
     * @param bool $save Determines whether to save the model in the database. If save is set to true, the model is
     *                   saved in the database, otherwise it is not saved in database.
     *                   By default, save is set to true.
     *
     * @return Model     Return an instance of model.
     */
    public static function create(array $values, bool $save = true) {
        $modelObj = new static();

        foreach ($modelObj->getModelAttributes() as $attribute) {
            //check that the model fillable attributes, exists in values array
            if(array_key_exists($attribute, $values)) {
                $modelObj->{$attribute} = $values[$attribute];
            }
        }

        //If the saved is set to true, the model is saved in databse
        if($save) {
            $modelObj->save();
        }

        return $modelObj;
    }

    public function update(array $values) {
        //TODO: implement update method
    }

    public function save(): bool {
        //TODO: implement save method
    }
}
