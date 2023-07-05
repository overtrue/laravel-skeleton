<?php

namespace Infrastructure\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    protected $dontReport = [
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function invalidJson($request, ValidationException $exception): \Illuminate\Http\JsonResponse
    {
        $errors = $exception->errors();
        $firstError = \reset($errors);

        return response()->json([
            'message' => $firstError[0] ?? '参数错误',
            'errors' => $errors,
        ], $exception->status);
    }
}
