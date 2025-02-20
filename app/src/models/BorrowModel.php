<?php
namespace App\models;

use App\Models\SqlConnect;
use PDO;

class BorrowModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new SqlConnect())->db;
    }

    public function getAll()
    {
        $stmt = $this->conn->query("
            SELECT b.id, u.username, bk.title, b.borrow_date, b.return_date
            FROM borrows b
            JOIN users u ON b.user_id = u.id
            JOIN books bk ON b.book_id = bk.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("
            SELECT b.id, u.username, bk.title, b.borrow_date, b.return_date
            FROM borrows b
            JOIN users u ON b.user_id = u.id
            JOIN books bk ON b.book_id = bk.id
            WHERE b.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($user_id, $book_id, $borrow_date, $return_date = null)
    {
        $stmt = $this->conn->prepare("
            INSERT INTO borrows (user_id, book_id, borrow_date, return_date)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$user_id, $book_id, $borrow_date, $return_date]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $return_date)
    {
        $stmt = $this->conn->prepare("
            UPDATE borrows
            SET return_date = ?
            WHERE id = ?
        ");
        return $stmt->execute([$return_date, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM borrows WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
