<?php

namespace Amirmahvari\Todo\Http\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static \Amirmahvari\Todo\Http\Responses\JsonResponse success( $data = [] , string $message = 'success')
 * @method static \Amirmahvari\Todo\Http\Responses\JsonResponse error(string $status , array $data = [] , string $message = 'error')
 * @method static \Amirmahvari\Todo\Http\Responses\JsonResponse notFound()
 * @method static \Amirmahvari\Todo\Http\Responses\JsonResponse unauthorized()
 *
 * @see \Illuminate\Routing\Router
 */
class JsonResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Amirmahvari\Todo\Http\Responses\JsonResponse::class;
    }
}
