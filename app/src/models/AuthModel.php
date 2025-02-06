<?php

namespace App\Models;

use App\Models\SqlConnect;
use App\Utils\{HttpException, JWT};
use \PDO;

class AuthModel extends SqlConnect {
  private string $table  = "users";
  private int $tokenValidity = 3600;
  private string $passwordSalt = "sqidq7sà";
  
  public function register(array $data) {
    $query = "SELECT email FROM $this->table WHERE email = :email";
    $req = $this->db->prepare($query);
    $req->execute(["email" => $data["email"]]);
    
    if ($req->rowCount() > 0) {
      throw new HttpException("User already exist!", 400);
    }

    // Hasher le mot de passe
    $data["password"] = password_hash($data["password"], PASSWORD_BCRYPT);
    $password_salted = $data["password"] . $this->passwordSalt;
    $data["password"] = password_hash($password_salted, PASSWORD_BCRYPT);

    // Créer l'utilisateur
    $query_add = "INSERT INTO $this->table ( email, password) VALUES ( :email, :password )";
    $req2 = $this->db->prepare($query_add);
    $req2->execute([
      "email" => $data["email"],
      "password" => $data["password"]
    ]);

    $userId = $this->db->lastInsertId();

    // Générer le token JWT
    $token = $this->generateJWT($userId);

    return ['token' => $token];
  }

  public function login($email, $password) {
    $query = "SELECT * FROM $this->table WHERE email = :email";
    $req = $this->db->prepare($query);
    $req->execute(['email' => $email]);

    $user = $req->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $token = $this->generateJWT($user['id']);
        return ['token' => $token];
    } else {
        throw new \Exception("Invalid credentials.");
    }
  }

  private function generateJWT(string $userId) {
    $payload = [
      'user_id' => $userId,
      'exp' => time() + $this->tokenValidity
    ];
    return JWT::generate($payload);
  }
}