// components/BottomNav

"use client";

import Link from "next/link";

 // *~*~*~*~*~*~* Bottom Navigation Component *~*~*~*~*~*~*

type NavItem = {
  label: string;
  href?: string;
  onClick?: () => void;
  className: string;
};

// can edit the items when using the component on a page
// since they are specific to the page and are not global
type Props = {
  items: NavItem[];
};

// *~*~*~*~*~*~* BOTTOM NAV TEMPLATE *~*~*~*~*~*~*

export default function BottomNav({ items }: Props) {
  return (
    <nav
      className="navbar navbar-bottom fixed-bottom navbar-sanctuary navbar-dark border-top d-flex align-items-center"
    >
      <div className="container-fluid justify-content-around align-items-center">

        {items.map((item, index) =>
          item.onClick ? (
            <button
              key={index}
              type="button"
              className={`btn ${item.className} rounded-pill px-3`}
              onClick={item.onClick}
            >
              {item.label}
            </button>
          ) : (
            <Link
              key={index}
              href={item.href || "#"}
              className={`btn ${item.className} rounded-pill px-3`}
            >
              {item.label}
            </Link>
          )
        )}

      </div>
    </nav>
  );
}