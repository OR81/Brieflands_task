<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        //این خطا در فایل مقصد نیز مورد بررسی قرار میگیرد
        //انجام این کار در این بخش از نظر برنامه نویس بهتر بوده چرا که بررسی این خطا در این مرحله باعث میشود که خطا به سیستم routing نرسد
        $this->renderable(function (PostTooLargeException $e, $request) {
            return response()->json(['error' => 'File size exceeds the allowed limit'], 422);
        });
    }
}
