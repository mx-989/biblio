<?php
namespace App\middlewares;

use App\utils\JWT;
use App\utils\HttpException;

class AuthMiddleware
{
    public function handle()
    {
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) {
            throw new HttpException('Authorization header missing', 401);
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $payload = JWT::decode($token);

        if (!$payload) {
            throw new HttpException('Invalid or expired token', 401);
        }

        // Stocker le payload
        $_SERVER['user'] = $payload;
    }
}
