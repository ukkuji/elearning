<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use RuntimeException;

class JwtService
{
    public function generate(User $user): string
    {
        $header = $this->base64UrlEncode(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
        ], JSON_THROW_ON_ERROR));

        $payload = $this->base64UrlEncode(json_encode([
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => now()->addHours(2)->timestamp,
        ], JSON_THROW_ON_ERROR));

        $signature = $this->sign("$header.$payload");

        return "$header.$payload.$signature";
    }

    public function verify(string $token): array
    {
        $parts = explode('.', $token);

        if (count($parts) !== 3) {
            throw new RuntimeException('Token format is invalid.');
        }

        [$header, $payload, $signature] = $parts;
        $expectedSignature = $this->sign("$header.$payload");

        if (! hash_equals($expectedSignature, $signature)) {
            throw new RuntimeException('Token signature is invalid.');
        }

        $decodedPayload = json_decode($this->base64UrlDecode($payload), true, flags: JSON_THROW_ON_ERROR);

        if (($decodedPayload['exp'] ?? 0) < time()) {
            throw new RuntimeException('Token has expired.');
        }

        return $decodedPayload;
    }

    private function sign(string $value): string
    {
        return $this->base64UrlEncode(hash_hmac('sha256', $value, $this->secret(), true));
    }

    private function secret(): string
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            return base64_decode(Str::after($key, 'base64:'), true) ?: $key;
        }

        return $key;
    }

    private function base64UrlEncode(string $value): string
    {
        return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
    }

    private function base64UrlDecode(string $value): string
    {
        return base64_decode(strtr($value, '-_', '+/'), true) ?: '';
    }
}
