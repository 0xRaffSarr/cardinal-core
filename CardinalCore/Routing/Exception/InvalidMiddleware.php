<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Exception;


class InvalidMiddleware extends \CardinalCore\Exception\Exception
{
    protected string $errorType = '05';
    protected int $defaultErrorCode = 2;
}
