<?php

namespace Amirabbas8643\Todo\Http\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static \Amirabbas8643\Todo\Http\Responses\JsonResponse success(array $data = [] , string $message = 'success')
 * @method static \Amirabbas8643\Todo\Http\Responses\JsonResponse error(string $status , array $data = [] , string $message = 'error')
 * @method static \Amirabbas8643\Todo\Http\Responses\JsonResponse notFound()
 * @method static \Amirabbas8643\Todo\Http\Responses\JsonResponse unauthorized()
 *
 * @see \Illuminate\Routing\Router
 */
class JsonResponse extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Amirabbas8643\Todo\Http\Responses\JsonResponse::class;
    }
}
