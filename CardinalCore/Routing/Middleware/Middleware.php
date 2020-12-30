<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Middleware;

use CardinalCore\Http\Request;

abstract class Middleware implements MiddlewareContracts
{

    /**
     * @inheritDoc
     */
    public function handle(Request $request)
    {
        // TODO: Implement handle() method.
    }

    /**
     * @inheritDoc
     */
    public function next(Request $request)
    {
        // TODO: Implement next() method.
    }

    /**
     * @inheritDoc
     */
    public function redirect(Request $request)
    {
        // TODO: Implement redirect() method.
    }
}
