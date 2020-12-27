<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Exception;

use CardinalCore\Exception\Exception;

class DatabaseException extends Exception
{
    protected string $errorType = '00';
    protected int $defaultErrorCode = 1;
}
