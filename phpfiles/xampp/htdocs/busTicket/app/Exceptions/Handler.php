<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Http\Traits\ProjectResponse;
use Illuminate\Http\Response;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    use ProjectResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
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
        $this->reportable(function (\PDOException $e) {
            return $this->getErrors($e->getMessage(), Response::HTTP_NOT_MODIFIED);
        });

        $this->reportable(function (\ValidationException $e) {
            return $this->getErrors($e->getErrorMassage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        $this->reportable(function (Throwable $e) {
            return $this->getErrors('Something went wrong!', Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        $this->reportable(function (Exception $e) {
            return $this->getErrors('Something went wrong!', Response::HTTP_INTERNAL_SERVER_ERROR);
        });

        $this->renderable(function (Exception $e) {
            dd($e->getMessage());
        });
    }
}
