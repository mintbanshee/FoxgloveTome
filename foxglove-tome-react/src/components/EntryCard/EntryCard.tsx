// components/EntryCard

import { Entry } from "@/lib/api";
import Link from "next/link";

type Props = {
  entry: Entry;
};

// *~*~*~*~*~*~* CONTROL HOW ENTRIES ARE DISPLAYED *~*~*~*~*~*~*

// truncate content to 100 for preview cards on dashboard
function truncateContent(content: string, maxLength = 100) {
  // if content is shorter than 100 keep it as is
  if (content.length <= maxLength) {
    return content;
  }
  // otherwise truncate
  return `${content.substring(0, maxLength)}...`;
}

// format date as MM/DD/YYYY for display on dashboard cards
function formatDate(dateString: string) {
  const date = new Date(dateString);

  // if date is invalid, return original string
  if (Number.isNaN(date.getTime())) {
    return dateString;
  }

  // otherwise format as MM/DD/YYYY
  return date.toLocaleDateString();
}

// get mood category icon for the entered mood
function getMoodIcon(moodCategory: string) {
  switch (moodCategory.toLowerCase()) {
    case "blooming":
      return "/images/categories/Blooming.png";
    case "rooted":
      return "/images/categories/Rooted.png";
    case "wilted":
      return "/images/categories/Wilted.png";
    case "prickly":
      return "/images/categories/Prickly.png";
    default:
      return null;
  }
}

// card component for displaying journal entry previews on dashboard
export default function EntryCard({ entry }: Props) {
  // name the mood category icon for ease of use
  const iconPath = getMoodIcon(entry.mood_category);

  // render the entry cards with their information and mood icons
  return (
    <Link href={`/entries/${entry.entry_id}`}
      className="text-decoration-none text-dark">
    <div className="entryCard px-2 py-1 mb-3 shadow-sm">
      <div className="card-body">
        <small className="date text-muted fst-italic d-block mb-2">
          {formatDate(entry.date_created)}
        </small>

        <h5 className="title montecarlo-regular card-title mb-2">
          {entry.title}
        </h5>

        <p className="moodRow mb-1 text-muted">
          <span className="moodText">{entry.mood}</span>

          {iconPath && (
            <img
              src={iconPath}
              alt={entry.mood_category}
              className="moodIcon"
            />
          )}
        </p>

        <p className="description text-muted fs-6 fst-italic text-truncate">
          {truncateContent(entry.content)}
        </p>
      </div>
    </div>
    </Link>
  );
}