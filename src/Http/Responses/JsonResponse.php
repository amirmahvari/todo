<?php

namespace Amirabbas8643\Todo\Http\Responses;

use Illuminate\Http\Response;

class JsonResponse
{

    /**
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     *
     * success request with return data
     */
    public function success(array $data = [] , string $message = 'success')
    {
        return response()->json([
            'status'  => Response::HTTP_OK ,
            'success' => true ,
            'message' => $message ,
            'data'    => $data ,
        ] , Response::HTTP_OK);
    }

    /**
     * @param string $status
     * @param array $data
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     *
     * error request with list errors
     */
    public function error(string $status , array $data = [] , string $message = 'error')
    {
        return response()->json([
            'status'  => $status ,
            'success' => false ,
            'message' => $message ,
            'data'    => $data ,
        ] , $status);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * not found 404
     */
    public function notFound()
    {
        return response()->json([
            'status'  => Response::HTTP_NOT_FOUND ,
            'success' => true ,
            'message' => 'not found' ,
        ] , Response::HTTP_NOT_FOUND);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * unauthorized
     */
    public function unauthorized()
    {
        return response()->json([
            'status'  => Response::HTTP_NOT_FOUND ,
            'success' => true ,
            'message' => 'Unauthorized' ,
        ] , Response::HTTP_UNAUTHORIZED);
    }
}
