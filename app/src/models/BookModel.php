<?php
namespace App\models;

use App\Models\SqlConnect;
use PDO;

class BookModel
{
    private $conn;

    public function __construct()
    {
        $this->conn = (new SqlConnect())->db;
    }

    public function getAll()
    {
        $sql = "
            SELECT
                books.*,
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM borrows
                        WHERE borrows.book_id = books.id
                          AND borrows.return_date IS NULL
                    )
                    THEN 1
                    ELSE 0
                END AS is_borrowed
            FROM books
        ";

        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "
            SELECT
                books.*,
                CASE
                    WHEN EXISTS (
                        SELECT 1
                        FROM borrows
                        WHERE borrows.book_id = books.id
                          AND borrows.return_date IS NULL
                    )
                    THEN 1
                    ELSE 0
                END AS is_borrowed
            FROM books
            WHERE books.id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $author_id, $published_at)
    {
        $stmt = $this->conn->prepare("INSERT INTO books (title, author_id, published_at) VALUES (?, ?, ?)");
        $stmt->execute([$title, $author_id, $published_at]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $title, $author_id, $published_at)
    {
        $stmt = $this->conn->prepare("
            UPDATE books 
            SET title = ?, author_id = ?, published_at = ? 
            WHERE id = ?
        ");
        return $stmt->execute([$title, $author_id, $published_at, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM books WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
