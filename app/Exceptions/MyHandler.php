<?php

namespace App\Exceptions;

use stdClass;
use Throwable;

class MyHandler extends Handler
{

    public $exception;

    /**
     * Class constructor.
     */
    public function __construct(Throwable $e = null, int $status = 500)
    {
        $this->exception = new stdClass;
        $this->exception->status = $status;
        if ($e) {
            $this->exception->code = $e->getCode();
            $this->exception->message = $e->getMessage();
            $this->exception->file = $e->getFile();
            $this->exception->line = $e->getLine();
        }
    }

    public static function toJson(Throwable $e = null, int $status = 500)
    {
        $myHandler = new MyHandler($e, $status);

        return json_encode($myHandler->exception);
    }
}
