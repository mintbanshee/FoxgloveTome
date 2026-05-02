// src/app/login

"use client";

import { FormEvent, useState } from "react";
import { useRouter } from "next/navigation";
import { loginUser } from "../../lib/auth";

// *~*~*~*~*~*~* LOGIN PAGE *~*~*~*~*~*~*

export default function LoginPage() {
  const router = useRouter();

  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(false);

  // *~*~*~*~*~*~* HANDLE SUBMIT *~*~*~*~*~*~*

  async function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setError("");
    setLoading(true);

    try {
      // Attempt to log in the user
      await loginUser({ email, password });
      // navigate to the dashboard if successful
      router.push("/dashboard");
      // Refresh the page to load dashboard data
      router.refresh();
  
    } catch (err) {
      // Handle errors and display an appropriate message
      if (err instanceof Error) {
        setError(err.message);
      } else {
        setError("Login failed.");
      }
    // reset loading state
    } finally {
      setLoading(false);
    }
  }
// *~*~*~*~*~*~* DISPLAY LOGIN PAGE *~*~*~*~*~*~*
  return (
    <div className="loginBG">
      <div className="container py-5">
        <div className="row justify-content-center">
          <div className="col-12 col-sm-10 col-md-6 col-lg-4">
            <div className="loginCard p-4">
              <h1 className="login-title">Login</h1>

              {error && (
                <div className="alert alert-danger">
                  <div>{error}</div>
                </div>
              )}

              <form onSubmit={handleSubmit}>
                <div className="mb-4 mt-4 text-start">
                  <label htmlFor="email" className="form-label">
                    Email
                  </label>
                  <input
                    id="email"
                    name="email"
                    type="email"
                    className="form-control"
                    autoComplete="email"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    required
                  />
                </div>

                <div className="mb-4 text-start">
                  <label htmlFor="password" className="form-label">
                    Password
                  </label>
                  <input
                    id="password"
                    name="password"
                    type="password"
                    className="form-control"
                    autoComplete="current-password"
                    value={password}
                    onChange={(e) => setPassword(e.target.value)}
                    required
                  />
                </div>

                <button
                  type="submit"
                  className="btn btn-outline-light rounded-pill px-4 mt-4 w-100"
                  disabled={loading}
                >
                  {loading ? "Opening the Tome..." : "Log In"}
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}