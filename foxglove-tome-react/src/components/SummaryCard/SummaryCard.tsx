// components/SummaryCard

import { MoodSummary } from "@/lib/api";

type Props = {
  summary: MoodSummary;
};

// *~*~*~*~*~*~* WEEKLY MOOD SUMMARY *~*~*~*~*~*~*

// Component to display the weekly mood summary
// uses the MoodSummary type from the API to show the dominant mood and an optional quote

export default function SummaryCard({ summary }: Props) {
  return (
    <div className="summaryCard mb-4 py-3 shadow-sm">
      <div className="card-body text-center">
        <h4 className="montecarlo-regular card-title mb-2">
          Weekly Mood Summary
        </h4>

        <p className="flourish mb-2">
          <sub>⟡</sub><sup>⟡</sup>
        </p>

        {summary.dominantMood ? (
          <>
            <p className="text-muted">
              This week, you have been feeling mostly {summary.dominantMood}.
            </p>

            {summary.quote && (
              <p className="fst-italic mt-2">
                "{summary.quote}"
              </p>
            )}
          </>
        ) : (
          <p className="text-muted">
            Your story is still unfolding this week 🌱
          </p>
        )}
      </div>
    </div>
  );
}