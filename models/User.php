<?php
class User {
  private PDO $conn;

  public $user_id, $username, $email, $password_hash, $role;

  public function __construct() {
    require __DIR__ . '/../db/database.php';
    $this->conn = $pdo;
  }

  public function getTotalUsers() {
    $sql = "SELECT COUNT(*) FROM users";
    $statement = $this->conn->query($sql);
    return (int) $statement->fetchColumn();
  }
}