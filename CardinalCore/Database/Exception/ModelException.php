<?php
/*
 * Copyright (c) 2021. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Database\Exception;


class ModelException extends DatabaseException
{
    protected string $errorType = '00';
    protected int $defaultErrorCode = 2;
}
