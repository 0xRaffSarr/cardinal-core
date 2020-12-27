<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Exception;

use Throwable;

class Exception extends \Exception
{
    protected string $errorType = '00';
    protected int $defaultErrorCode = 0;

    public function __construct($message = "", $code = null, Throwable $previous = null)
    {
        if(is_null($code)) {
            $code = $this->defaultErrorCode;
        }

        $message = "CardinalError (".$code."x".$this->errorType.") ".$message;

        parent::__construct($message, $code, $previous);
    }
}
