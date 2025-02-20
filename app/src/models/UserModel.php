<?php
namespace App\models;

use App\Models\SqlConnect;
use PDO;

class UserModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new SqlConnect())->db;
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT id, username, email, is_admin FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT id, username, email, is_admin, password FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($username, $email, $passwordHash, $isAdmin = 0)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $passwordHash, $isAdmin]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $username, $email, $isAdmin)
    {
        $stmt = $this->conn->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE id = ?");
        return $stmt->execute([$username, $email, $isAdmin, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function updatePassword($id, $newHash)
    {
        $stmt = $this->conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$newHash, $id]);
    }    
}
