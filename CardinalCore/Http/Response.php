<?php
/**
 * Copyright (c) 2020. Cardinal
 * Author: Raffaele Sarracino - https://raffaelesarracino.it
 */

namespace CardinalCore\Http;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

abstract class Response
{
    /**
     * @param string $to
     * @param int $status
     * @param array $headers
     * @return RedirectResponse
     */
    public static function redirectTo(string $to, int $status = 302, array $headers = []) {
        return new RedirectResponse($to, $status, $headers);
    }

    /**
     * @param null $data
     * @param int $status
     * @param array $headers
     * @param bool $json
     * @return JsonResponse
     */
    public static function json($data = null, int $status = 200, array $headers = [], bool $json = false) {
        return new JsonResponse($data, $status, $headers, $json);
    }
}
