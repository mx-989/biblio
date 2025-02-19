<?php
namespace App\controllers;

use App\models\BookModel;
use App\utils\HttpException;

class BookController
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $books = $this->bookModel->getAll();
        echo json_encode($books);
    }

    public function show($id)
    {
        $book = $this->bookModel->getById($id);
        if (!$book) {
            throw new HttpException('Book not found', 404);
        }
        echo json_encode($book);
    }

    public function store()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);

        $title = $inputData['title'] ?? null;
        $author_id = $inputData['author_id'] ?? null;
        $published_at = $inputData['published_at'] ?? null;

        if (!$title || !$author_id) {
            throw new HttpException('Missing title or author_id', 400);
        }

        $newId = $this->bookModel->create($title, $author_id, $published_at);
        echo json_encode(['message' => 'Book created', 'id' => $newId]);
    }

    /**
     * Mise à jour partielle : conserve les anciennes valeurs si non fournies.
     */
    public function update($id)
    {
        $book = $this->bookModel->getById($id);
        if (!$book) {
            throw new HttpException('Book not found', 404);
        }

        $inputData = json_decode(file_get_contents('php://input'), true);

        // Conserver les anciennes valeurs si absentes
        $title = $inputData['title'] ?? $book['title'];
        $author_id = $inputData['author_id'] ?? $book['author_id'];
        $published_at = $inputData['published_at'] ?? $book['published_at'];

        $this->bookModel->update($id, $title, $author_id, $published_at);
        echo json_encode(['message' => 'Book updated']);
    }

    public function destroy($id)
    {
        $book = $this->bookModel->getById($id);
        if (!$book) {
            throw new HttpException('Book not found', 404);
        }

        $this->bookModel->delete($id);
        echo json_encode(['message' => 'Book deleted']);
    }
}
