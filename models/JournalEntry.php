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

  // retrieve a specific journal entry by its ID and ensure it belongs to the user
  public function getEntryById(int $entryId, int $userId): ?array {
    $sql = "SELECT * 
            FROM journalEntries 
            WHERE entry_id = :entry_id AND user_id = :user_id";

    $statement = $this->conn->prepare($sql);
    $statement->bindValue(':entry_id', $entryId, PDO::PARAM_INT);
    $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
    $statement->execute();
    
    $entry = $statement->fetch(PDO::FETCH_ASSOC);
    return $entry ?: null; 
  }

  // update an existing journal entry
  public function update(
    int $entryId, 
    int $userId, 
    string $title, 
    string $content, 
    string $moodCategory, 
    string $mood
  ): bool {
    $sql = "UPDATE journalEntries 
            SET title = :title, 
                content = :content, 
                mood_category = :mood_category, 
                mood = :mood, 
                date_updated = NOW()
            WHERE entry_id = :entry_id 
              AND user_id = :user_id";

    $statement = $this->conn->prepare($sql);

    return $statement->execute([
      ':entry_id' => $entryId,
      ':user_id' => $userId,
      ':title' => $title,
      ':content' => $content,
      ':mood_category' => $moodCategory,
      ':mood' => $mood
    ]);
  } 

  // delete a journal entry
  public function delete(int $entryId, int $userId): bool {
    $sql = "DELETE FROM journalEntries
            WHERE entry_id = :entry_id 
              AND user_id = :user_id";

    $statement = $this->conn->prepare($sql);

    return $statement->execute([
      ':entry_id' => $entryId,
      ':user_id' => $userId
    ]);
  }

  // get total number of journal entries for the entire app
  public function getTotalEntries(): int {
    $sql = "SELECT COUNT(*) FROM journalEntries";
    $statement = $this->conn->query($sql);
    return (int) $statement->fetchColumn();
  }

  // get the most common mood across all journal entries
  public function getMostCommonMood(): ?string {
    $sql = "SELECT mood, COUNT(*) AS count
            FROM journalEntries
            GROUP BY mood
            ORDER BY count DESC
            LIMIT 1";

    $statement = $this->conn->query($sql);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['mood'] : '-';
  }

  // get weekly mood stats for the weekly mood summary 
  public function getWeeklyMoodSummary(int $userID): array {
    $entries = $this->getEntriesByUser($userID);

    $weeklyEntries = [];
    $moodCounts = []; // how often each mood is logged in the past week
    $dominantMood = null; // start with no dominant mood
    $dominantCategory = null; // start with no dominant category

    $oneWeekAgo = strtotime('-7 days'); // 7 days for the week 

    foreach ($entries as $entry) {
        // make sure to only include entries from the past 7 days
        if (strtotime($entry['date_created']) >= $oneWeekAgo) { 
            $weeklyEntries[] = $entry;

            // count the moods in the entries 
            $mood = $entry['mood'];
            // if this mood is not already counted - start the counting process and start with 0
            if (!isset($moodCounts[$mood])) {
                $moodCounts[$mood] = 0;
            }
            // get the final count for each mood
            $moodCounts[$mood]++;
            }
        }
        // which mood is logged the most in the entries from the 7 days
        if (!empty($moodCounts)) { // only continue if there are moods to count
            arsort($moodCounts); // sort by count
            $dominantMood = array_key_first($moodCounts); // get the mood with the highest count
        // which category does the dominant mood belong to
            foreach ($weeklyEntries as $entry) { // loop through the entries
                if ($entry['mood'] === $dominantMood) { // find the dominant mood in the entries
                    $dominantCategory = $entry['mood_category']; // get the category of the dominant mood
                  break; 
                }
            }

          // load quotes and pick one quote that matches the dominant mood category
          $quotes = require __DIR__ . '/../config/quotes.php';

          if ($dominantCategory && isset($quotes[$dominantCategory])) {
              $categoryQuotes = $quotes[$dominantCategory];
              // pick a random quote from the category
              $randomIndex = array_rand($categoryQuotes);
              // get the selected quote for the mood summary section
              $selectedQuote = $categoryQuotes[$randomIndex];
          } else {
            // if no dominant category the quote is null 
              $selectedQuote = null;
          }
        }
        return [
          // return the dominant mood and the quote.
            'dominantMood' => $dominantMood,
            'dominantCategory' => $dominantCategory,
            'quote' => $selectedQuote
        ];
  }

} // close class JournalEntry