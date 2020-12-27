<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Exception;


class InvalidArgumentException extends \CardinalCore\Exception\Exception
{
    protected string $errorType = '01';
}
