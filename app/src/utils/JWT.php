<?php
namespace App\utils;

class JWT
{
    private static $secret = "shika-shika"; // Mettre ça dans un .env en production

    public static function generate(array $payload): string
    {
        $header = ['alg' => 'HS256', 'typ' => 'JWT'];
        $base64Header = self::base64UrlEncode(json_encode($header));
        
        $base64Payload = self::base64UrlEncode(json_encode($payload));

        $signatureData = $base64Header . '.' . $base64Payload;
        $rawSignature = hash_hmac('sha256', $signatureData, self::$secret, true);
        $base64Signature = self::base64UrlEncode($rawSignature);

        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    public static function verify(string $jwt): bool
    {
        $parts = explode('.', $jwt);
        if (count($parts) !== 3) {
            return false;
        }

        list($header, $payload, $signature) = $parts;
        $expected = self::base64UrlEncode(
            hash_hmac('sha256', "$header.$payload", self::$secret, true)
        );

        return hash_equals($expected, $signature);
    }

    public static function decode(string $jwt): ?array
    {
        if (!self::verify($jwt)) {
            return null;
        }

        list($header, $payload, $signature) = explode('.', $jwt);
        $jsonPayload = base64_decode(strtr($payload, '-_', '+/'));
        $decoded = json_decode($jsonPayload, true);

        return $decoded;
    }

    private static function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
