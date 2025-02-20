<?php
namespace App\controllers;

use App\models\UserModel;
use App\utils\JWT;
use App\utils\HttpException;

class AuthController
{
    public function login()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);
        $username = $inputData['username'] ?? null;
        $password = $inputData['password'] ?? null;

        if (!$username || !$password) {
            throw new HttpException('Missing username or password', 400);
        }

        $userModel = new UserModel();
        $user = $userModel->getByUsername($username);

        if (!$user) {
            throw new HttpException('User not found', 404);
        }

        if (!password_verify($password, $user['password'])) {
            throw new HttpException('Invalid credentials', 401);
        }

        $payload = [
            'user_id' => $user['id'],
            'username' => $user['username'],
            'is_admin' => (int)$user['is_admin']
        ];
        $token = JWT::generate($payload);

        echo json_encode([
            'message' => 'Login successful',
            'token' => $token
        ]);
    }
}
