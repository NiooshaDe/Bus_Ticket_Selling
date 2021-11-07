<?php

namespace App\Traits;

class Response
{
    public function getErrors($error, $status)
    {
        return ['message' => $error, 'status' => $status];
    }
}
