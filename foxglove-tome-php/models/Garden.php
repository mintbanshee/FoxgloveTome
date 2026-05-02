<?php

// *~*~*~*~*~*~* GARDEN MODEL *~*~*~*~*~*~*

// class representing the user's garden
class Garden {
  public $garden_id, $user_id, $flower_type, $date_added;

  // get the monthly entries for the user's garden
  public function getMonthlyEntries(int $userId): array {
    require_once __DIR__ . '/JournalEntry.php';

    $journalEntry = new JournalEntry();
    $entries = $journalEntry->getEntriesByUser($userId);

    // filter entries to only include those from the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // return the filtered entries
    return array_filter($entries, function ($entry) use ($currentMonth, $currentYear) {
        return date('m', strtotime($entry['date_created'])) == $currentMonth
            && date('Y', strtotime($entry['date_created'])) == $currentYear;
    });
  }

  // group the monthly entries by week
  public function getMonthlyEntriesByWeek(int $userId): array {
    $monthlyEntries = $this->getMonthlyEntries($userId);

    $weeks = [
        1 => [],
        2 => [],
        3 => [],
        4 => [],
        5 => []
    ];

    foreach ($monthlyEntries as $entry) {
    $dayOfMonth = (int) date('j', strtotime($entry['date_created']));

    // Determine the week number based on the day of the month
    if ($dayOfMonth <= 7) {
        $weekNumber = 1;
    } elseif ($dayOfMonth <= 14) {
        $weekNumber = 2;
    } elseif ($dayOfMonth <= 21) {
        $weekNumber = 3;
    } elseif ($dayOfMonth <= 26) {
        $weekNumber = 4;
    } else {
        $weekNumber = 5;
    }

    // Add the entry to the appropriate week
    $weeks[$weekNumber][] = $entry;
}

    return $weeks;
}
  
}