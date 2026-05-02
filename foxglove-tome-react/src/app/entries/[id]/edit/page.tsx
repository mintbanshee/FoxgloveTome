// src/app/entries/[id]/edit/page.tsx

"use client";

import { FormEvent, useEffect, useState } from "react";
import { useParams, useRouter } from "next/navigation";
import { getEntryById, updateEntryById } from "@/lib/api";
import BottomNav from "@/components/BottomNav/BottomNav";

// *~*~*~*~*~*~* EDIT ENTRY PAGE *~*~*~*~*~*~*

// Mood options categorized by mood category
const moodOptions = {
  Blooming: ["Joyful", "Hopeful", "Excited", "Proud", "Loved", "Happy", "Optimistic", "Accomplished", "Strong", "Confident", "Inspired"],
  Rooted: ["Calm", "Grounded", "Content", "Peaceful", "Stable", "Grateful", "Focused", "Resilient", "Balanced", "Secure", "Safe"],
  Wilted: ["Sad", "Drained", "Lonely", "Heavy", "Tired", "Disappointed", "Hopeless", "Discouraged", "Vulnerable", "Confused", "Helpless"],
  Prickly: ["Anxious", "Frustrated", "Overwhelmed", "Restless", "Irritated", "Stressed", "Agitated", "Traumatized", "Nervous", "Uncomfortable"],
};

export default function EditEntryPage() {
  const router = useRouter();

  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");
  const [mood, setMood] = useState("");
  const [moodCategory, setMoodCategory] = useState("");
  const [error, setError] = useState("");
  const params = useParams();
  const id = params.id as string;

  // Handle form submission to update the entry
  async function handleSubmit(e: FormEvent<HTMLFormElement>) {
    e.preventDefault();
    setError("");

    // Validate form fields
    try {
      await updateEntryById(id, {
        title,
        content,
        mood,
        mood_category: moodCategory,
      });

      // Redirect to dashboard with success message and refresh to show updated entry
      router.push("/dashboard?success=updated");
      router.refresh();
    } catch (err) {
      setError(err instanceof Error ? err.message : "Failed to update entry.");
    }
  }

  // Load existing entry data on mount
  useEffect(() => {
  async function loadEntry() {
    try {
      const data = await getEntryById(id);

      // Pre-fill form with existing entry data
      setTitle(data.title);
      setContent(data.content);
      setMood(data.mood);
      setMoodCategory(data.mood_category);

    } catch (err) {
      setError("Failed to load entry.");
    }
  }

  // Only attempt to load entry if we have an ID from the URL
  if (id) {
    loadEntry();
  }
}, [id]);

  /*====== display the edit entry form prefilled and ready for editing ======
  ===================  including bottom navigation =================== */

  return (
    <main className="container py-5">

      <div className="dashboardShell mx-auto">
        <div className="entryFormCard p-4">
          <h1 className="formHeader text-center mb-4">Edit Entry</h1>

          {error && (
            <div className="alert alert-danger">
              {error}
            </div>
          )}

          <form onSubmit={handleSubmit}>
            <div className="mb-3">
              <label htmlFor="title" className="form-label">Title</label>
              <input
                id="title"
                name="title"
                className="form-control"
                value={title}
                onChange={(e) => setTitle(e.target.value)}
                required
              />
            </div>

            <div className="mb-4">
              <p className="fw-semibold mb-3">Select a mood category:</p>

              <div className="d-flex flex-wrap gap-3 justify-content-center mood-category-icons">
                {["Blooming", "Rooted", "Wilted", "Prickly"].map((category) => (
                  <button
                    key={category}
                    type="button"
                    className={`mood-icon-btn btn p-0 border-0 bg-transparent ${
                      moodCategory === category ? "selected" : ""
                    }`}
                    onClick={() => {
                      setMoodCategory(category);
                      setMood("");
                    }}
                  >
                    <img
                      src={`/images/categories/${category}.png`}
                      alt={`${category} mood category`}
                      width="50"
                    />
                  </button>
                ))}
              </div>
            </div>

            <div className="mb-4">
              <p className="fw-semibold mb-3">Select your mood:</p>

              <select
                id="mood"
                name="mood"
                className="form-select"
                value={mood}
                onChange={(e) => setMood(e.target.value)}
                disabled={!moodCategory}
                required
              >
                <option value="">
                  {moodCategory ? "-- Select a mood --" : "-- Choose a category first --"}
                </option>

                {moodCategory &&
                  [...moodOptions[moodCategory as keyof typeof moodOptions]]
                    .sort()
                    .map((moodOption) => (
                      <option key={moodOption} value={moodOption}>
                        {moodOption}
                      </option>
                    ))}
              </select>
            </div>

            <div className="mb-3">
              <label htmlFor="content" className="form-label">Content</label>
              <textarea
                id="content"
                name="content"
                className="form-control"
                rows={5}
                value={content}
                onChange={(e) => setContent(e.target.value)}
                required
              />
            </div>

            <BottomNav
              items={[
                {
                  label: "Cancel",
                  href: "/dashboard",
                  className: "btn-light btn-outline-danger",
                },
                {
                  label: "Save Entry",
                  onClick: () => {
                    document.querySelector("form")?.requestSubmit();
                  },
                  className: "btn-light btn-outline-success",
                },
              ]}
            />

          </form>
        </div>
      </div>
    </main>
  );
}