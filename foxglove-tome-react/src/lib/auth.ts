// src/lib/auth.ts

const API_BASE = process.env.NEXT_PUBLIC_API_BASE_URL;

if (!API_BASE) {
  throw new Error("NEXT_PUBLIC_API_BASE_URL is not defined");
}

// *~*~*~*~*~*~* LOGIN USER *~*~*~*~*~*~*

export type LoginResponse = {
  user: {
    user_id: number;
    email: string;
    username: string;
    role: string;
    name: string;
  };
};

export async function loginUser(data: {
  email: string;
  password: string;
}): Promise<LoginResponse> {

  // Make a POST request to the login endpoint with the provided email and password
  const response = await fetch(`${API_BASE}auth/login.php`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    credentials: "include",
    body: JSON.stringify(data),
  });

  // Parse the JSON response from the server
  const result = await response.json();

  // Check if the login was successful based on the status in the response
  if (result.status !== "success") {
    throw new Error(result.message || "Login failed");
  }

  // Return the user data from the response
  return result.data;
}



// *~*~*~*~*~*~* LOGOUT USER *~*~*~*~*~*~*

export async function logoutUser() {
  // Make a POST request to the logout endpoint to log the user out
  const response = await fetch(`${API_BASE}auth/logout.php`, {
    method: "POST",
    credentials: "include",
  });

  // Parse the JSON response from the server
  return response.json();
}