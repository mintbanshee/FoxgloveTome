<?php
class User {
  private PDO $conn;

  public $user_id, $username, $email, $password_hash, $role;

  public function __construct() {
    require __DIR__ . '/../db/database.php';
    $this->conn = $pdo;
  }

  // get the total number of users for the admin dashboard stats
  public function getTotalUsers() {
    $sql = "SELECT COUNT(*) FROM users";
    $statement = $this->conn->query($sql);
    return (int) $statement->fetchColumn();
  }

  // get all users for the admin manage users page
  public function getAllUsers(): array {
    $sql = "SELECT user_id, username, email, role, first_name, last_name, date_joined
            FROM users
            ORDER BY date_joined DESC";

    $statement = $this->conn->query($sql);
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// get a single user by ID (used for editing user details in admin panel)
public function getUserById(int $user_id): array|false {
    $sql = "SELECT user_id, username, email, role, first_name, last_name, date_joined
            FROM users
            WHERE user_id = :user_id
            LIMIT 1";

    $statement = $this->conn->prepare($sql);
    $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $statement->execute();
    
    return $statement->fetch(PDO::FETCH_ASSOC);
}

// update a user's role (promote/demote) in the admin panel
public function updateUserRole(int $userId, string $role): bool {
    $sql = "UPDATE users SET role = :role WHERE user_id = :user_id";

    $statement = $this->conn->prepare($sql);
    $statement->bindValue(':role', $role);
    $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);

    return $statement->execute();
}
}