// src/components/DashboardFlash/DashboardFlash.tsx

"use client";

import { useSearchParams, useRouter } from "next/navigation";
import { useEffect } from "react";

// *~*~*~*~*~*~* FLASH MESSAGE COMPONENT *~*~*~*~*~*~*

// manage success messages for the dashboard
export default function DashboardFlash() {
  const searchParams = useSearchParams();
  const router = useRouter();
  const success = searchParams.get("success");

  // set a timer for the flash message to disappear so
  // the user does not feel the need to refresh the page
  useEffect(() => {
    if (success) {
      const timer = setTimeout(() => {
        router.replace("/dashboard");
      }, 3000);

      return () => clearTimeout(timer);
    }
  }, [success, router]);

  if (!success) return null;

  let message = "";

  switch (success) {
    // saved new entry
    case "stored":
      message = "Your thoughts have been safely stored in the tome.";
      break;

    // deleted entry
    case "deleted":
      message = "This page has been safely removed from the tome.";
      break;

    // edited entry 
    case "updated":
      message = "The changes to your entry have been safely stored in the tome";
      break;

    default:
      return null;
  }

  return (
    <div className="dashboardShell mx-auto mb-3">
      <div className="alert alert-success shadow-sm text-center rounded-3 mb-3">
        {message}
      </div>
    </div>
  );
}