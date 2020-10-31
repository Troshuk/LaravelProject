<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * [register description]
     * @return [type] [description]
     * @author Denys Troshuk
     */
    public function register()
    {
        /**
         * renderable function will catch all Throwable errors
         * and return them in response by making response as error
         * with status code in HTTP standard
         *
         * This is a dynmic form of making the errors returns always in the same structure
         *
         * @param \Throwable $exception
         * @param Request $request
         *
         * @return response in JSON
         * @author Denys Troshuk
         */
        $this->renderable(function (\Throwable $exception, Request $request) {
            switch (get_class($exception)) {
                case ValidationException::class:
                    $status_code = $exception->status;
                    foreach ($exception->errors() as $error) {
                        $message = $exception->validator->errors()->first();
                        break;
                    }
                    break;

                default:
                    $status_code = method_exists($exception, 'getStatusCode')
                    ? $exception->getStatusCode()
                    : (
                        method_exists($exception, 'getCode')
                        && $exception->getCode() > 0
                        ? $exception->getCode()
                        : 500
                    );

                    $message = $exception->getMessage();
                    break;
            }

            $result = [
                'message' => $message,
                'code' => $status_code,
            ];

            if (env('APP_DEBUG')) {
                $result['file'] = $exception->getFile();
                $result['line'] = $exception->getLine();
                $result['trace'] = $exception->getTrace();
            }

            return response()
                ->json($result)
                ->setStatusCode($status_code, $message);
        });
    }
}
