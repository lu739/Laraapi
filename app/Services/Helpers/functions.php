<?php

function responseOk($status = 200, $return = []): \Illuminate\Http\JsonResponse
{
    $returnedArray = array_merge([
        'message' => 'success'
    ], $return);

    return response()->json($returnedArray, $status);
}
