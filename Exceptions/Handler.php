<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Traits\ResponseHelperTrait;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    use ResponseHelperTrait;
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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

    public function render($request, Throwable $e)
    {


        if ($request->is('api/*')) {

            // Not Found Http Exception
            if ($e instanceof NotFoundHttpException) {
                return $this->returnWrong("error 404", $request->url() . ' Not Found, try with correct url', 404);
            }

            // Method Not Allowed Http Exception
            if ($e instanceof MethodNotAllowedHttpException) {
                return $this->returnWrong("error 405", request()->method() . ' method Not allow for this route, try with correct method', 405);
            }

            // Authorization Exception
            if ($e instanceof AuthorizationException) {
                return $this->returnWrong('Un Authorized', '', JsonResponse::HTTP_FORBIDDEN);
            }

            // Authentication Exception
            if ($e instanceof AuthenticationException) {
                return $this->returnWrong('Un Authentication', '', JsonResponse::HTTP_UNAUTHORIZED);
            }

            // Validation Exception
            if ($e instanceof ValidationException) {
                return $this->returnWrong('Un Authentication', $e->errors(), 422);
            }

            // Throwable
            if ($e instanceof Throwable) {
                return $this->returnWrong($e->getMessage());
            }
        }


        return parent::render($request, $e);
    }
}
