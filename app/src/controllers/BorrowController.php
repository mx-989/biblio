<?php
namespace App\controllers;

use App\models\BorrowModel;
use App\utils\HttpException;

class BorrowController
{
    private $borrowModel;

    public function __construct()
    {
        $this->borrowModel = new BorrowModel();
    }

    public function index()
    {
        $borrows = $this->borrowModel->getAll();
        echo json_encode($borrows);
    }

    public function show($id)
    {
        $borrow = $this->borrowModel->getById($id);
        if (!$borrow) {
            throw new HttpException('Borrow not found', 404);
        }
        echo json_encode($borrow);
    }

    public function store()
    {
        $inputData = json_decode(file_get_contents('php://input'), true);

        $user_id = $inputData['user_id'] ?? null;
        $book_id = $inputData['book_id'] ?? null;
        $borrow_date = $inputData['borrow_date'] ?? date('Y-m-d');
        $return_date = $inputData['return_date'] ?? null;

        if (!$user_id || !$book_id) {
            throw new HttpException('Missing user_id or book_id', 400);
        }

        $newId = $this->borrowModel->create($user_id, $book_id, $borrow_date, $return_date);
        echo json_encode(['message' => 'Borrow created', 'id' => $newId]);
    }

    public function update($id)
    {
        $borrow = $this->borrowModel->getById($id);
        if (!$borrow) {
            throw new HttpException('Borrow not found', 404);
        }

        $inputData = json_decode(file_get_contents('php://input'), true);
        $return_date = $inputData['return_date'] ?? date('Y-m-d');

        $this->borrowModel->update($id, $return_date);
        echo json_encode(['message' => 'Borrow updated']);
    }

    public function destroy($id)
    {
        $borrow = $this->borrowModel->getById($id);
        if (!$borrow) {
            throw new HttpException('Borrow not found', 404);
        }

        $this->borrowModel->delete($id);
        echo json_encode(['message' => 'Borrow deleted']);
    }
}
