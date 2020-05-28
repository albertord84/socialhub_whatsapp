<?php
namespace App\Business;

use Exception;

class MyException extends Exception
{
    static $COMPANY_PHONE_NOT_FOUND = 1000;
    static $ERROR_SAVING_FILE_MSG_FOUND = 1001;

    /**
     * Class constructor.
     */
    public function __construct(string $msg, int $code)
    {
        parent::__construct($msg, $code);
    }

    // /**
    //  * Class constructor.
    //  */
    // public function __construct(Throwable $e = null)
    // {
    //     $this->exception = $e;
    // }

    public function __toString()
    {
        MyResponse::makeExceptionJson($this);
    }
}
