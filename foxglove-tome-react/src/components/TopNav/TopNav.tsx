// components/TopNav

"use client";

import Link from "next/link";

// *~*~*~*~*~*~* CONTROL AND DISPLAY TOP NAVIGATION *~*~*~*~*~*~*

export default function TopNav() {

  return (
    <nav className="navbar navbar-expand-lg navbar-sanctuary fixed-top px-3">
      <div className="topNavInner d-flex align-items-center justify-content-between w-100">

        <Link href="/" className="navbar-brand d-flex align-items-center">
          <img
            src="/images/logo/FoxgloveTome.svg"
            alt="Foxglove Tome"
            className="navLogo"
          />
        </Link>

            <Link href="/dashboard" className="nav-link p-0">
              <img
                src="/images/icons/accountWhite.png"
                alt="Account"
                width="30"
                height="30"
                className="accountIcon"
              />
            </Link>
      </div>
    </nav>
  ); 
}