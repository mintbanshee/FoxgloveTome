// components/DashboardClient

"use client";

import { useEffect, useState } from "react";
import { getEntries, getMoodSummary, Entry, MoodSummary } from "../../lib/api";
import EntryCard from "../EntryCard/EntryCard";
import SummaryCard from "../SummaryCard/SummaryCard";
import BottomNav from "../BottomNav/BottomNav";
import { useRouter } from "next/navigation";
import { logoutUser } from "../../lib/auth";
import DashboardFlash from "../DashboardFlash/DashboardFlash";

// *~*~*~*~*~*~* CONTROL DASHBOARD BEHAVIOR *~*~*~*~*~*~*

export default function DashboardClient() {
  const [entries, setEntries] = useState<Entry[]>([]);
  const [summary, setSummary] = useState<MoodSummary | null>(null);
  const [error, setError] = useState("");
  const [loading, setLoading] = useState(true);

  const router = useRouter();

  // Handle user logout
  const handleLogout = async () => {
    try {
      // wait for logout to complete before redirecting
      await logoutUser();
    } catch (error) {
      // error handling with redirect
      console.error("Logout failed:", error);
    } finally {
      router.push("/login");
      router.refresh();
    }
  };

  // Load dashboard data
  useEffect(() => {
    async function loadDashboard() {
      try {
        const [entriesData, summaryData] = await Promise.all([
          // get entries and summary
          getEntries(),
          getMoodSummary(),
        ]);

        // set entries and summary state
        setEntries(entriesData);
        setSummary(summaryData);
      } catch (err) {
        // if dashboard load fails, redirect to login 
        // (if it fails it is liekly because they are not logged in)
          router.push("/login");
      } finally {
        setLoading(false);
      }
    }

    loadDashboard();
  }, [router]);

  // *~*~*~*~*~*~* DASHBOARD DISPLAY *~*~*~*~*~*~*
  
  if (loading) {
    return (
      <main className="container py-5">
        <div className="dashboardShell mx-auto">
          <p className="text-center text-muted">Loading...</p>
        </div>
      </main>
    );
  }

  if (error) {
    return (
      <main className="container py-5">
        <div className="dashboardShell mx-auto">
          <div className="alert alert-danger">{error}</div>
        </div>
      </main>
    );
  }


    /*====== determines how the dashboard is displayed ======
  ======  using the specific components in their positions  ======
  ==================  includes bottom nav  ==================*/

    return (
    <>
      <main className="container py-5 mt-3">
        <div className="dashboardShell mx-auto">
            <DashboardFlash />

          <div className="mb-5 text-center">
            <h1 className="montecarlo-regular fw-bold">My Dashboard</h1>
          </div>

          {summary && <SummaryCard summary={summary} />}

          <h3 className="montecarlo-regular mb-3 fw-bold">My Journal</h3>

          {entries.length === 0 ? (
            <div className="alert alert-light border">
              You have no journal entries yet. Start by creating your first entry!
            </div>
          ) : (
            <div className="list-group">
              {entries.map((entry) => (
                <EntryCard key={entry.entry_id} entry={entry} />
              ))}
            </div>
          )}
        </div>
      </main>

      <BottomNav
        items={[
          {
           label: "Logout",
           onClick: handleLogout,
           className: "btn-light btn-outline-danger",
          },
          {
           label: "+ New Entry",
           href: "/entries/new",
           className: "btn-light btn-outline-primary",
          },
        ]}
      />
    </>
  );
}