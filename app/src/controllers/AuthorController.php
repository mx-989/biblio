<?php
namespace App\controllers;

use App\models\AuthorModel;
use App\utils\HttpException;

class AuthorController
{
    private $authorModel;

    public function __construct()
    {
        $this->authorModel = new AuthorModel();
    }

    public function index()
    {
        $authors = $this->authorModel->getAll();
        echo json_encode($authors);
    }

    public function show($id)
    {
        $author = $this->authorModel->getById($id);
        if (!$author) {
            throw new HttpException('Author not found', 404);
        }
        echo json_encode($author);
    }

    public function store()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);
        $name = $inputData['name'] ?? null;

        if (!$name) {
            throw new HttpException('Missing name', 400);
        }

        $newId = $this->authorModel->create($name);
        echo json_encode(['message' => 'Author created', 'id' => $newId]);
    }

    public function update($id)
    {
        $author = $this->authorModel->getById($id);
        if (!$author) {
            throw new HttpException('Author not found', 404);
        }

        $inputData = json_decode(file_get_contents('php://input'), true);
        $name = $inputData['name'] ?? $author['name'];

        $this->authorModel->update($id, $name);
        echo json_encode(['message' => 'Author updated']);
    }

    public function destroy($id)
    {
        $author = $this->authorModel->getById($id);
        if (!$author) {
            throw new HttpException('Author not found', 404);
        }

        $this->authorModel->delete($id);
        echo json_encode(['message' => 'Author deleted']);
    }
}
