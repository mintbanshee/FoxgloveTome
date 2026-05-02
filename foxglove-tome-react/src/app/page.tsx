// src/app/page.tsx

import Link from "next/link";

// *~*~*~*~*~*~* DISPLAY HOME PAGE *~*~*~*~*~*~*

export default function HomePage() {
  return (
    <>
    <div id="top"></div>
      <div className="container-fluid p-0">
        <section
          id="heroSection"
          className="text-center d-flex flex-column justify-content-center align-items-center"
        >
          <div id="welcomeTitle" className="w-100 py-3">
            <h1 className="display-4 montecarlo-regular">
              The Foxglove Tome
            </h1>
            <p className="lead mb-0">
              A Digital Sanctuary for Mental Wellness
            </p>
          </div>

          <div className="container mt-5">
            <p id="welcomeMessage" className="lead fw-bold text-white">
              A gentle space to reflect, track your moods, and nurture your inner garden.
            </p>

            <Link
              href="/login"
              className="btn btn-light btn-outline-dark btn-lg rounded-pill px-4 mt-3"
            >
              Login
            </Link>
          </div>
        </section>
      </div>

      <section className="container py-4 text-center">
        <h2 className="mb-2">Features</h2>

        <p className="adminFlourish">
          <sub>⟡</sub>☾<sup>⟡</sup>
        </p>

        <p className="subtitle text-muted mb-3">
          A digital sanctuary designed to feel gentle, not overwhelming.
        </p>

        <p className="adminFlourish mb-3">✦ ━━ ⟡ ━━ ✦</p>

        <div className="row g-4">

          <div className="col-md-4">
            <h5 className="featureTitle">Write Freely</h5>
            <p>Capture your thoughts in a private, calming space designed for reflection.</p>
            <p>Create, edit, and revisit entries as your story unfolds over time.</p>
          </div>

          <div className="col-md-4">
            <h5 className="featureTitle">Understand Your Emotions</h5>
            <p>Select from thoughtfully organized mood categories to describe how you're feeling.</p>
            <p>Simple, clear, and never overwhelming.</p>
          </div>

          <div className="col-md-4">
            <h5 className="featureTitle">See Your Weekly Patterns</h5>
            <p>Receive a gentle summary of your most common mood each week.</p>
            <p>Paired with thoughtful reflections to guide you forward.</p>
          </div>

          <div className="col-md-4">
            <h5 className="featureTitle">Keep Your Thoughts Safe</h5>
            <p>Your journal belongs to you.</p>
            <p>Secure accounts ensure your reflections remain private and protected.</p>
          </div>

          <div className="col-md-4">
            <h5 className="featureTitle">Watch Your Garden Grow</h5>
            <p>Your emotional journey becomes a living garden.</p>
            <p>Each week blooms into a hand-crafted flower based on your mood patterns.</p>
            <p>Each flower is thoughtfully illustrated to reflect its emotional meaning.</p>
          </div>

          <div className="col-md-4">
            <h5 className="featureTitle">Designed for Comfort</h5>
            <p>A calm, welcoming interface that feels like a sanctuary.</p>
            <p>Built to be simple, supportive, and easy to return to.</p>
          </div>

          <div className="text-center mt-4">
            <a
              href="#top"
              className="btn btn-lg btn-outline-dark rounded-pill px-3 mt-1">
              Back to Top
            </a>
          </div>

        </div>
      </section>
    </>
  );
}