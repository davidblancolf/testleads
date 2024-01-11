<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\RequestException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->reportable(function (Throwable $e) {
            Log::error("Error:".$e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        $this->reportable(function (Throwable $e) {
            Log::error("Error:".$e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        });
        $this->renderable(function(NotFoundHttpException $e,Request $request){
            Log::warning($e->getMessage());
            if($request->is('api/*')){
                return response()->json(['message'=>$e->getMessage()],Response::HTTP_NOT_FOUND);
            }
        });
        $this->renderable(function(ValidationException $e,Request $request){
            Log::warning($e->getMessage());
            return response()->json(['message'=>$e->getMessage(),'errors'=>$e->errors()],Response::HTTP_UNPROCESSABLE_ENTITY);
        });
        $this->renderable(function(RequestException $e,Request $request){
            Log::warning($e->getMessage());
            return response()->json(['message'=>$e->getMessage()],Response::HTTP_FORBIDDEN);
        });

    }
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
