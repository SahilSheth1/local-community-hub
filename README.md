# Local Community Hub

A custom WordPress directory application that catalogs and categorizes
local businesses. Built to demonstrate mastery of the WordPress ecosystem,
custom data modeling, and PHP theme development.

## Live Demo
> Deployed via [LocalWP](https://localwp.com) — clone and run locally
> using the setup instructions below.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Core Engine | WordPress (Self-hosted) |
| Data Modeling | Advanced Custom Fields (ACF) |
| Theme | Custom Child Theme (PHP) |
| Languages | PHP, HTML5, CSS3, SQL |
| Dev Environment | LocalWP |

---

## Features

- **Custom Post Type** — Dedicated `Listings` section separate from standard WordPress posts
- **Structured Metadata** — ACF field groups for address, hours, phone, email, website, and price range
- **Taxonomy System** — Hierarchical categories (Restaurant, Retail, Healthcare) and flat tags (Pet Friendly, Open Late)
- **Search & Filter UI** — Front-end filtering by keyword, category, tag, and price range using `WP_Query`
- **Dynamic Templates** — Hand-coded `archive-listing.php` and `single-listing.php` PHP templates
- **Responsive Design** — Mobile-friendly grid layout using CSS Flexbox and Grid

---

## Project Structure

\`\`\`
lch-theme/
├── functions.php          # CPT registration, taxonomies, style enqueue
├── style.css              # Theme declaration + all custom styles
├── archive-listing.php    # Grid view of all listings with filter UI
├── single-listing.php     # Individual listing detail page
├── screenshot.png         # Theme preview image
└── inc/
    └── acf-fields.php     # ACF field group definitions (exported as PHP)
\`\`\`

---

## Local Setup

### Prerequisites
- [LocalWP](https://localwp.com) installed
- [Advanced Custom Fields](https://wordpress.org/plugins/advanced-custom-fields/) plugin

### Steps

1. Clone the repo
\`\`\`bash
git clone https://github.com/YOURUSERNAME/local-community-hub.git
\`\`\`

2. Create a new site in LocalWP

3. Copy the theme folder into:
\`\`\`
app/public/wp-content/themes/lch-theme
\`\`\`

4. Activate the theme in **WP Admin → Appearance → Themes**

5. Install and activate the **Advanced Custom Fields** plugin

6. The ACF field groups auto-register via `inc/acf-fields.php` — no manual setup needed

7. Go to **Settings → Permalinks** and click **Save Changes** to flush rewrite rules

8. Add listings via **WP Admin → Listings → Add New Listing**

---

## Development Roadmap

- [x] Phase 1 — Custom Post Type & Taxonomy registration
- [x] Phase 2 — ACF data schema & dummy listings
- [x] Phase 3 — Child theme, archive & single templates
- [x] Phase 4 — WP_Query search & filter UI
- [ ] Phase 5 — Google Maps API integration *(planned)*
- [ ] Phase 6 — User submission portal *(planned)*

---

## Author
**Your Name**
[GitHub](https://github.com/YOURUSERNAME) •
[LinkedIn](https://linkedin.com/in/YOURPROFILE)