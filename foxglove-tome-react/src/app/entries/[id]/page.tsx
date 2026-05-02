// src/app/entries/[id]/page.tsx

"use client";

import { useEffect, useState } from "react";
import { useRouter, useParams } from "next/navigation";
import { getEntryById, deleteEntryById } from "@/lib/api";
import BottomNav from "@/components/BottomNav/BottomNav";

// *~*~*~*~*~*~* VIEW ENTRY PAGE *~*~*~*~*~*~*

export default function EntryPage() {
  const params = useParams();
  const id = params.id as string;
  const router = useRouter();

  const [entry, setEntry] = useState<any>(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(true);
  const [showDeleteModal, setShowDeleteModal] = useState(false);

  // Load entry data on mount
  useEffect(() => {
    async function loadEntry() {
      try {
        const data = await getEntryById(id);
        setEntry(data);
      } catch (err) {
        setError(err instanceof Error ? err.message : "Failed to load entry.");
      } finally {
        setLoading(false);
      }
    }

    // Only attempt to load entry if we have an ID from the URL
    if (id) {
      loadEntry();
    }
  }, [id]);

  // Handle entry deletion
  async function handleDelete() {
    try {
      await deleteEntryById(id);
      router.push("/dashboard?success=deleted");
    } catch (err) {
      alert("Failed to delete entry.");
    }
  }

  // Render loading, error, or entry details
  if (loading) {
    return (
      <main className="container py-5">
        <p>Loading...</p>
      </main>
    );
  }
  if (error) {
    return (
      <main className="container py-5">
        <div className="alert alert-danger">{error}</div>
      </main>
    );
  }
  // If we have no entry data, show a not found message
  if (!entry) {
    return (
      <main className="container py-5">
        <div className="alert alert-warning">The keepers could not find that entry. It does not exist within the pages of the tome.</div>
      </main>
    );
  }

  /*====== display entry details with options to edit or delete ======
  ======  including bottom navigation & delete confirmation modal ======*/

  return (
    <>
      <main className="container py-5">
        <div className="dashboardShell mx-auto">
          <div className="detailsCard p-4 text-center mb-4">
            <p className="text-muted mb-2">{entry.date_created}</p>

            <h1 className="mb-3">{entry.title}</h1>

            <p className="text-muted mb-0">
              🌼 {entry.mood_category} - {entry.mood}
            </p>
          </div>

          <div className="contentCard p-3">
            <p className="mb-0">{entry.content}</p>
          </div>
        </div>
      </main>

      <BottomNav
        items={[
          {
            label: "Dashboard",
            href: "/dashboard",
            className: "btn-light btn-outline-success",
          },
          {
            label: "Delete",
            onClick: () => setShowDeleteModal(true),
            className: "btn-light btn-outline-danger",
          },
          {
            label: "Edit Entry",
            href: `/entries/${id}/edit`,
            className: "btn-light btn-outline-primary",
          },
        ]}
      />


      {showDeleteModal && (
        <>
          <div className="modal show d-block" tabIndex={-1}>
            <div className="modal-dialog modal-dialog-centered">
              <div className="modal-content foxgloveDeleteModal">
                <div className="modal-body text-center p-4">
                  <h2 className="deleteModalTitle mb-3">Delete Entry?</h2>

                  <p className="deleteModalText">
                    Are you sure you want to remove this entry from your tome?
                  </p>

                  <p className="deleteModalText small">
                    This cannot be undone.
                  </p>

                  <div className="d-flex justify-content-center gap-3 mt-4">
                    <button
                      type="button"
                      className="btn btn-light rounded-pill"
                      onClick={() => setShowDeleteModal(false)}
                    >
                      Keep Entry
                    </button>

                    <button
                      type="button"
                      className="btn btn-outline-light rounded-pill"
                      onClick={handleDelete}
                    >
                      Delete Entry
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div className="modal-backdrop show"></div>
        </>
      )}
    </>
  );
}