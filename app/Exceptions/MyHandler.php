<?php

namespace App\Exceptions;

use stdClass;
use Throwable;

class MyHandler extends Handler
{
    static function toJson(Throwable $e = null)
    {
        $exception = new stdClass();
        $exception->code = $e->getCode();
        $exception->message = $e->getMessage();
        $exception->file = $e->getFile();
        $exception->line = $e->getLine();
        return json_encode($exception);
    }
}
