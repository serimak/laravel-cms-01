<?php

namespace App\Exceptions;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Validation\ValidationException as ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\Access\AuthorizationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        NotFoundHttpException::class,
        ModelNotFoundException::class
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
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Illuminate\Http\Request  $request
    * @param  \Exception  $exception
    * @return \Illuminate\Http\Response
     */
    public function report( Exception $exception)
    {
       
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    

    public function render($request, Exception $exception)
    {
        // return $this->handleApiError($exception);
        return parent::render($request, $exception);
    }

    private function handleApiError(Exception $e) {

        $errors = config('app.debug') ? ['cause' => "{$e->getFile()}, {$e->getLine()}", 'trace' => $e->getTrace()] : null;
        if ($e instanceof AuthorizationException) {
            return response()->json([
                'resultCode' => '40300',
                'resultDescription' => IlluminateResponse::$statusTexts[403],
                'errors' => $errors,
                'developerMessage' => $e->getMessage(),
            ], 403);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'resultCode' => '40400',
                'resultDescription' => IlluminateResponse::$statusTexts[404],
                'errors' => $errors,
                'developerMessage' => $e->getMessage(),
            ], 404);
        }

        if ($e instanceof ValidationException) {
            return response()->json([
                'resultCode' => '42200',
                'resultDescription' => IlluminateResponse::$statusTexts[422],
                'errors' => $e->errors(),
                'developerMessage' => $e->getMessage(),
            ], 422);
        }

        if ($e instanceof HttpException) {
            return response()->json([
                'resultCode' => $e->getStatusCode().'00',
                'resultDescription' => IlluminateResponse::$statusTexts[$e->getStatusCode()],
                'errors' => $errors,
                'developerMessage' => $e->getMessage(),
            ], $e->getStatusCode());
        }

        if ($e instanceof \PDOException) {
            return response()->json([
                'resultCode' => '50300',
                'resultDescription' => IlluminateResponse::$statusTexts[503],
                'errors' => $e->getMessage(),
                'developerMessage' => $e->getMessage(),
            ], 503);
        }

        return response()->json([
            'resultCode' => '50000',
            'resultDescription' => IlluminateResponse::$statusTexts[500],
            'errors' => $errors,
            'developerMessage' => $e->getMessage(),
        ], 500);
    }
}
