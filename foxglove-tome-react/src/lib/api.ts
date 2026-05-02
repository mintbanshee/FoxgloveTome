// src/lib/api

const API_BASE = process.env.NEXT_PUBLIC_API_BASE_URL;

if (!API_BASE) {
  throw new Error('API base URL is not defined.');
}

// define the entry type
export type Entry = {
  entry_id: number;
  user_id: number;
  title: string;
  content: string;
  mood_category: string;
  mood: string;
  date_created: string;
  date_updated: string;
};

type ApiResponse<T> = {
  status: string;
  data: T;
  message?: string;
};

// Helper function to handle API responses
async function handleResponse<T>(response: Response): Promise<T> {
  if (!response.ok) {
    throw new Error(`HTTP error: ${response.status}`);
  }
  return response.json();
}

// *~*~*~*~*~*~* GET ENTRIES FUNCTION *~*~*~*~*~*~*

export async function getEntries(): Promise<Entry[]> {
  const response = await fetch(`${API_BASE}entries/read.php`, {
    cache: 'no-store',
    credentials: 'include',
  });
  
  const result = await handleResponse<ApiResponse<Entry[]>>(response);

  if (result.status !== 'success') {
    throw new Error(result.message || 'Failed to fetch entries');
  }
  
  return result.data; 
}

// *~*~*~*~*~*~* GET MOOD SUMMARY FUNCTION *~*~*~*~*~*~*

export type MoodSummary = {
  dominantMood: string | null;
  dominantCategory: string | null;
  quote: string | null;
};

export async function getMoodSummary(): Promise<MoodSummary> {
  const response = await fetch(`${API_BASE}entries/summary.php`, {
    cache: "no-store",
    credentials: "include",
  });

  const result = await handleResponse<ApiResponse<MoodSummary>>(response);

  if (result.status !== "success") {
    throw new Error(result.message || "Failed to fetch mood summary");
  }

  return result.data;
}

// *~*~*~*~*~*~* GET ENTRY BY ID *~*~*~*~*~*~*

export async function getEntryById(id: string) {
  const res = await fetch(`${API_BASE}entries/read_byId.php?id=${id}`, {
    credentials: "include",
  });

  const data = await res.json();

  if (data.status !== "success") {
    throw new Error(data.message);
  }

  return data.data;
}

// *~*~*~*~*~*~* CREATE ENTRY FUNCTION *~*~*~*~*~*~*

export async function createEntry(data: {
  title: string;
  content: string;
  mood: string;
  mood_category: string;
  date_created?: string;
  date_updated?: string;
}) {

  const response = await fetch(`${API_BASE}entries/create.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    credentials: "include",
    body: JSON.stringify(data),
  });

  const result = await response.json();

  if (result.status !== "success") {
    throw new Error(result.message || "Failed to create entry");
  }

  return result;
}

// *~*~*~*~*~*~* UPDATE ENTRY FUNCTION *~*~*~*~*~*~*

export async function updateEntryById(id: string, entry: any) {
  const res = await fetch(`${API_BASE}entries/update.php?id=${id}`, {
    method: "POST",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(entry),
  });

  const data = await res.json();

  if (data.status !== "success") {
    throw new Error(data.message);
  }

  return data;
}

// *~*~*~*~*~*~* DELETE ENTRY FUNCTION *~*~*~*~*~*~*

export async function deleteEntryById(id: string) {
  const res = await fetch(`${API_BASE}entries/delete.php?id=${id}`, {
    method: "POST",
    credentials: "include",
  });

  const data = await res.json();

  if (data.status !== "success") {
    throw new Error(data.message);
  }
}