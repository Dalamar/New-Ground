<?php


namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @param  ResponseFactory $factory
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', [$this, 'api']);
    }


    /**
     * Returns JSON response for API requests in unified format suitable for the project.
     *
     * @param null $payload
     * @param array $errors
     * @param null $httpStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function api($payload = null, $errors = [], $httpStatus = null)
    {
        $responseStatus = !empty($errors) ? 'error' : 'success';
        $httpStatus = $httpStatus ?: (!empty($errors) ? HttpResponse::HTTP_BAD_REQUEST : HttpResponse::HTTP_OK);
        $responseData = [
            'status' => $responseStatus,
            'message' => $errors,
            'payload' => $payload,
            'time' => strftime('%F %T'),
        ];

        return response()->json($responseData, $httpStatus);
    }
}