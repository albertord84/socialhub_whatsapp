<?php
namespace App\Business;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class MyResponse
{
    /**
     *  Make Json Response by Request and Erro
     *
     * @param Request $request
     * @param Throwable $e
     * @return void
     */
    public static function makeRequestExceptionJson(Request $request = null, Throwable $e): JsonResponse
    {
        if ($request && $request->ajax() || $request->wantsJson()) {
            $json = [
                'success' => false,
                'error' => [
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ],
            ];

            return response()->json($json, 400);
        }
    }

    /**
     * Make Json Response by message and data
     *
     * @param string $msg
     * @param [type] $data
     * @param integer $code
     * @param boolean $success
     * @return string
     */
    public static function makeResponseJson(string $msg, $data = null, int $code = 0, $success = true): string
    {
        $json = [
            'success' => $success,
            'code' => $code,
            'message' => $msg,
            'data' => $data,
        ];
        return json_encode($json);
    }

    public static function makeExceptionJson(Throwable $th) {
        Log::error('makeExceptionJson Throwable: ', [$th]);
        return self::makeResponseJson($th->getMessage(), $th->getTrace(), $th->getCode(), false);
    }
}
