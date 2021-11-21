<?php


namespace App\Http\Traits;
use Illuminate\Http\Response;

trait ProjectResponse
{
    public function getErrors($error, $status)
    {
        return response()->json(['message' => $error, 'status' => $status]);
    }

    public function showData($data)
    {
        return response()->json(['data' => $data, 'status' => Response::HTTP_OK]);
    }

    public function showMessage($message)
    {
        return response()->json(['message' => $message, 'status' => Response::HTTP_OK]);
    }

    //return given token with response
    public function showToken($token)
    {
        return response()->json(['token' => $token], Response::HTTP_OK);
    }
}
