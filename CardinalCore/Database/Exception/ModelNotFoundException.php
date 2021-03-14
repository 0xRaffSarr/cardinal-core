<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Exception;

use Throwable;

/**
 * Class ModelNotFoundException
 *
 * This exception is raised when trying to retrieve a model from the database, which is not found.
 *
 * @package CardinalCore\Database\Exception
 */
class ModelNotFoundException extends ModelException
{
    protected string $errorType = '00';
    protected int $defaultErrorCode = 3;

    public function __construct($message = "Model not found in database", $code = null, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
