<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Routing\Middleware;


use CardinalCore\Http\Request;

interface MiddlewareContracts
{
    /**
     * It is invoked for condition verification
     *
     * @param Request $request
     * @return mixed
     */
    public function handle(Request $request);

    /**
     * Defines the action to be taken if the condition is true
     *
     * @param Request $request
     * @return mixed
     */
    public function next(Request $request);

    /**
     * Define the redirect path
     *
     * @param Request $request
     * @return mixed
     */
    public function redirect(Request $request);
}
