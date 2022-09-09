<?php

namespace App\Exceptions;

use App\Helpers\ApiResponse;
use App\Helpers\ResponseEnum;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        $code = $exception->getCode();
        if ($exception instanceof AuthenticationException) {
            $code = 401;
        } elseif ($exception instanceof ValidationException) {
            $code = 403;
        }

        if (!$exception instanceof BusinessException) {
            if( $code==401){
                return response()->json([
                    'status' => 'fail',
                    'code' => $code,
                    'message' => $exception->getMessage(),
                    'data' => null,
                    'error' => null,
                ])->setStatusCode(500);
            }
            return response()->json([
                'status' => 'fail',
                'code' => $code,
                'message' => $exception->getMessage(),
                'data' => null,
                'error' => null,
            ])->setStatusCode(500);
        }
        return parent::render($request, $exception); // TODO: Change the autogenerated stub

    }
}
