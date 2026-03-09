<?php 
declare(strict_types=1);


class JournalEntry {
  private PDO $conn; // Database connection

  public function __construct() {
    require __DIR__ . '/../db/database.php';
    $this->conn = $pdo; // Assign the PDO connection to the class property
  }

  // create a new journal entry
  public function create (
    int $userId, 
    string $title, 
    string $content, 
    string $moodCategory, 
    string $mood
  ): bool {

  // Insert the new journal entry into the database
    $sql = "INSERT INTO journalEntries 
      (user_id, title, content, mood_category, mood, date_created, date_updated)
      VALUES 
      (:user_id, :title, :content, :mood_category, :mood, NOW(), NOW())";

    $statement = $this->conn->prepare($sql);

    // Execute the statement with the provided parameters
    return $statement->execute([
      ':user_id' => $userId,
      ':title' => $title,
      ':content' => $content,
      ':mood_category' => $moodCategory,
      ':mood' => $mood
    ]);
  }

  // retrieve all journal entries for a specific user
  public function getEntriesByUser(int $userId): array {
    $sql = "SELECT * 
            FROM journalEntries 
            WHERE user_id = :user_id 
            ORDER BY date_created DESC";

    $statement = $this->conn->prepare($sql); 
    $statement->execute([':user_id' => $userId]);
    
    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  // retrieve a specific journal entry by its ID
  public function getEntryById(int $entryId): ?array {
    $sql = "SELECT * 
            FROM journalEntries 
            WHERE entry_id = :entry_id";

    $statement = $this->conn->prepare($sql);
    $statement->bindValue(':entry_id', $entryId, PDO::PARAM_INT); 
    $statement->execute();
    
    $entry = $statement->fetch(PDO::FETCH_ASSOC);
    return $entry ?: null; 
  }
}
