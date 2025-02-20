<?php
namespace App\controllers;

use App\models\UserModel;
use App\utils\HttpException;

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        echo json_encode($users);
    }

    public function show($id)
    {
        $user = $this->userModel->getById($id);
        if (!$user) {
            throw new HttpException('User not found', 404);
        }
        unset($user['password']);
        echo json_encode($user);
    }

    public function store()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);

        $username = $inputData['username'] ?? null;
        $email = $inputData['email'] ?? null;
        $password = $inputData['password'] ?? null;
        $isAdmin = isset($inputData['is_admin']) ? (int)$inputData['is_admin'] : 0;

        if (!$username || !$email || !$password) {
            throw new HttpException('Missing username, email or password', 400);
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $newId = $this->userModel->create($username, $email, $passwordHash, $isAdmin);
        echo json_encode(['message' => 'User created', 'id' => $newId]);
    }

    public function update($id)
    {
        $user = $this->userModel->getById($id);
        if (!$user) {
            throw new HttpException('User not found', 404);
        }

        $inputData = json_decode(file_get_contents('php://input'), true);
        $username = $inputData['username'] ?? $user['username'];
        $email = $inputData['email'] ?? $user['email'];
        $isAdmin = isset($inputData['is_admin']) ? (int)$inputData['is_admin'] : $user['is_admin'];

        $this->userModel->update($id, $username, $email, $isAdmin);
        echo json_encode(['message' => 'User updated']);
    }

    public function destroy($id)
    {
        $user = $this->userModel->getById($id);
        if (!$user) {
            throw new HttpException('User not found', 404);
        }

        $this->userModel->delete($id);
        echo json_encode(['message' => 'User deleted']);
    }

    public function changePassword($id)
    {
        $user = $this->userModel->getById($id);
        if (!$user) {
            throw new HttpException('User not found', 404);
        }
    
        $connectedUser = $_SERVER['user']; 
    
        $isSameUser = ($connectedUser['user_id'] == $id);
        $isAdmin = ($connectedUser['is_admin'] == 1);
    
        if (!$isSameUser && !$isAdmin) {
            throw new HttpException('Forbidden', 403);
        }
    
        $inputData = json_decode(file_get_contents('php://input'), true);
        $oldPassword = $inputData['old_password'] ?? null;
        $newPassword = $inputData['new_password'] ?? null;
    
        if (!$newPassword) {
            throw new HttpException('Missing new_password', 400);
        }
    
        if (!$isAdmin) {
            if (!$oldPassword) {
                throw new HttpException('Missing old_password', 400);
            }
            if (!password_verify($oldPassword, $user['password'])) {
                throw new HttpException('Invalid old password', 401);
            }
        }
    
        $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
    
        $this->userModel->updatePassword($id, $newHash);
    
        echo json_encode([
            'message' => 'Password changed successfully'
        ]);
    }
    
}
