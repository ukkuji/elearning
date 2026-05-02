<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\JwtService;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $this->unauthorized('Bearer token is required.');
        }

        try {
            $payload = app(JwtService::class)->verify($token);
            $user = User::find($payload['sub'] ?? null);
        } catch (Throwable $exception) {
            return $this->unauthorized($exception->getMessage());
        }

        if (! $user) {
            return $this->unauthorized('Token user was not found.');
        }

        auth()->setUser($user);
        $request->setUserResolver(fn () => $user);

        return $next($request);
    }

    private function unauthorized(string $message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 401);
    }
}
