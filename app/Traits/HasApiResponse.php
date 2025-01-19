<?php

namespace App\Traits;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

trait HasApiResponse
{
    public function okResponse(string $message, $data = null): JsonResponse
    {
        return $this->successResponse($message, 200, $data);
    }

    public function createdResponse(string $message, $data = null): JsonResponse
    {
        return $this->successResponse($message, 201, $data);
    }

    public function noContentResponse(): JsonResponse
    {
        return $this->successResponse('', 204);
    }

    public function badRequestResponse(string $message): JsonResponse
    {
        return $this->errorResponse($message, 400);
    }

    public function unauthorizedResponse(string $message): JsonResponse
    {
        return $this->errorResponse($message, 401);
    }

    public function forbiddenResponse(string $message): JsonResponse
    {
        return $this->errorResponse($message, 403);
    }

    public function notFoundResponse(string $message): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }

    public function tooManyRequestsResponse($message): JsonResponse
    {
        return $this->errorResponse($message, 429);
    }

    public function successResponse($message, $code, $data = null): JsonResponse
    {
        return $this->jsonResponse($message, $code, $data);
    }

    public function errorResponse($message, $code): JsonResponse
    {
        return $this->jsonResponse($message, $code);
    }

    public function serverErrorResponse(?Exception $exception = null): JsonResponse
    {
        $message = 'Sorry! Something went wrong!';

        if (!is_null($exception)) {
            if ($exception instanceof AuthorizationException) {
                return $this->unauthorizedResponse('You are not authorized to perform this action.');
            }

            $knownErrorResponses = [400, 401, 403, 404, 429];
            if (in_array($exception->getCode(), $knownErrorResponses)) {
                return $this->errorResponse($exception->getMessage(), $exception->getCode());
            }

            $error = "{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}";

            Log::error($exception);

            return $this->jsonResponse($message, 500, null, $error);
        }

        return $this->jsonResponse($message, 500, null);
    }

    private function jsonResponse(string $message, int $status, $data = null, string $devError = null): JsonResponse
    {
        $response = [
            'status' => $this->isStatusCodeSuccessful($status) ? 'success' : 'error',
            'message' => $message,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        if (!is_null($devError) && env('APP_DEBUG') == 'true') {
            $response['dev_error'] = $devError;
        }

        return Response::json($response, $status);
    }

    private function isStatusCodeSuccessful(int $status): bool
    {
        return $status >= 200 && $status < 300;
    }
}
