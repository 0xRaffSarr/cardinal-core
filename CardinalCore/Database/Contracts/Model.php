<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Contracts;


interface Model
{
    /**
     * Delete the model object and data form database
     *
     * @return mixed
     */
    public function delete();

    /**
     * Create a new model object and save data into database
     *
     * @param array $values
     * @return mixed
     */
    public function create(array $values);

    /**
     * Update a model information and save it into database
     *
     * @param array $values
     * @return mixed
     */
    public function update(array $values);

    /**
     * Save the model data into database
     *
     * @return bool
     */
    public function save(): bool;
}
