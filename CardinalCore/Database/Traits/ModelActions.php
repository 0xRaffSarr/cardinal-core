<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Traits;

use CardinalCore\Database\Database;

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
     * @param array $values
     */
    public function create(array $values) {
        //TODO: implement create method
    }

    public function update(array $values) {
        //TODO: implement update method
    }

    public function save(): bool {
        //TODO: implement save method
    }
}
