<?php
namespace App;

use App\controllers\AuthController;
use App\controllers\BookController;
use App\controllers\AuthorController;
use App\controllers\UserController;
use App\controllers\BorrowController;
use App\middlewares\AuthMiddleware;
use App\middlewares\AdminMiddleware;
use App\utils\Route;

class Router
{
    private $routes = [];

    public function __construct()
    {
        // Auth
        $this->routes[] = new Route('POST', '/login', [AuthController::class, 'login']);

        // Livres
        $this->routes[] = new Route('GET', '/books', [BookController::class, 'index']);
        $this->routes[] = new Route('GET', '/books/{id}', [BookController::class, 'show']);
        $this->routes[] = new Route(
            'POST',
            '/books',
            [BookController::class, 'store'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'PUT',
            '/books/{id}',
            [BookController::class, 'update'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'DELETE',
            '/books/{id}',
            [BookController::class, 'destroy'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );

        // Auteurs
        $this->routes[] = new Route('GET', '/authors', [AuthorController::class, 'index']);
        $this->routes[] = new Route('GET', '/authors/{id}', [AuthorController::class, 'show']);
        $this->routes[] = new Route(
            'POST',
            '/authors',
            [AuthorController::class, 'store'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'PUT',
            '/authors/{id}',
            [AuthorController::class, 'update'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'DELETE',
            '/authors/{id}',
            [AuthorController::class, 'destroy'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );

        // Utilisateurs
        $this->routes[] = new Route(
            'GET',
            '/users',
            [UserController::class, 'index'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'GET',
            '/users/{id}',
            [UserController::class, 'show'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'POST',
            '/users',
            [UserController::class, 'store'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'PUT',
            '/users/{id}',
            [UserController::class, 'update'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'DELETE',
            '/users/{id}',
            [UserController::class, 'destroy'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );

        // Emprunts
        $this->routes[] = new Route(
            'GET',
            '/borrows',
            [BorrowController::class, 'index'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'GET',
            '/borrows/{id}',
            [BorrowController::class, 'show'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'POST',
            '/borrows',
            [BorrowController::class, 'store'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'PUT',
            '/borrows/{id}',
            [BorrowController::class, 'update'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'DELETE',
            '/borrows/{id}',
            [BorrowController::class, 'destroy'],
            [AuthMiddleware::class, AdminMiddleware::class]
        );
        $this->routes[] = new Route(
            'POST',
            '/users/{id}/change-password',
            [UserController::class, 'changePassword'],
            [AuthMiddleware::class]
        );        
    }

    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $uri = explode('?', $uri)[0]; // enlever la query string

        foreach ($this->routes as $route) {
            if ($route->match($method, $uri)) {
                $route->call();
                return;
            }
        }

        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
    }
}
