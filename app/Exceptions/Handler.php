<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {

            $err = [];
            $errors = [];
            $tempIndex = 0;
            $message = 'Failure';
            foreach ($e->errors() as $key => $error) {
                $err['field_name'] = $key;
                $err['message'] = $error[0];
                $errors[] = $err;

                if ($tempIndex++ == 0){
                    $message = $error[0];
                }
            }

            $response = [
                'status' => true,
                'statusCode' => 422,
                'message' => $message,
                'items' => $errors,
            ];
            return response()->json($response);
        }
        return parent::render($request, $e); // TODO: Change the autogenerated stub
    }
}