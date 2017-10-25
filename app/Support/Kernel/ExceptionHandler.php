<?php namespace App\Support\Kernel;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Http\Response;

class ExceptionHandler extends Handler
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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
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
        if ($request->expectsJson()) {
            if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $modelClass = explode('\\', $exception->getModel());
                return $this->responseError(trans('databases.not_found', ['modelClass' => end($modelClass)]),
                    Response::HTTP_NOT_FOUND);
            }

            if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
                return $this->responseError(trans('auth.unauthorized'),
                    Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($exception instanceof \Illuminate\Validation\ValidationException) {
                return $this->responseError($exception->validator->errors(),
                    Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        if ($exception instanceof \Empari\Laravel\Support\Exceptions\Localization\LanguageNotSupportedException) {
            return $this->responseError(trans('localization.language_not_supported'),
                Response::HTTP_FORBIDDEN);
        }

        return parent::render($request, $exception);
    }

    /**
     * Prepare response Json
     *
     * @param string $message
     * @param int $code
     * @return array
     */
    public function prepareResponseJson($message = null, $code = 500)
    {
        return [
            'data' => [
                'error' => [
                    'code' => $code,
                    'message' => $message
                ]
            ]
        ];
    }

    /**
     * Response Error
     *
     * @param $message
     * @param $code
     * @return \Json
     */
    protected function responseError($message, $code)
    {
        return response()->json(
            $this->prepareResponseJson(
                $message,
                $code
            ),
            $code
        );
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return $this->responseError(trans('auth.unauthenticated'),
                Response::HTTP_UNAUTHORIZED);
        }

        abort(404);
    }

    /**
     * Prepare a JSON response for the given exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function prepareJsonResponse($request, \Exception $e)
    {
        $status = $this->isHttpException($e) ? $e->getStatusCode() : 500;

        $e = FlattenException::create($e);

        $error_response['code'] = $e->getStatusCode();
        $error_response['message'] = Response::$statusTexts[$e->getStatusCode()];

        if (config('app.debug')) {
            $error_response['exception'] = $e->getMessage();
            $error_response['class'] = $e->getClass();
            $error_response['file'] = $e->getFile();
            $error_response['line'] = $e->getLine();
            $error_response['trace'] = $e->getTrace();
        }

        return $this->responseError($error_response, $status);
    }
}
