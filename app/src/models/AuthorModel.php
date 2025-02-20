<?php
namespace App\models;

use App\Models\SqlConnect;
use PDO;

class AuthorModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new SqlConnect())->db;
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM authors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM authors WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO authors (name) VALUES (?)");
        $stmt->execute([$name]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE authors SET name = ? WHERE id = ?");
        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM authors WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
