# Nature Care Trust — Official Website

> **Where elders and ancient forests flourish together.**  
> Official public web platform for **Nature Care Trust** (`naturecaretrust.com`), a registered 80G charitable trust restoring native forest canopies, nurturing sacred groves, and providing barrier-free elder nature respite across the Western Ghats.

---

## 🌿 Overview

This repository contains the production-ready public website for Nature Care Trust. Built with performance, accessibility, and modern SEO best practices in mind, it delivers sub-second page loads, responsive layouts across all mobile and desktop viewports, and seamless integration with dynamic backend content feeds.

### 🎨 Design & Prototype Fidelity
- **Palette**: Deep Forest (`#012413`), Soft Sage (`#e9ffec`), Mint Accent (`#c7fad6`), Warm Terracotta (`#7d562d`), and Golden Sand (`#ffdf96`).
- **Typography**: *Source Serif 4* for elegant editorial headings and *Manrope* for high-legibility UI and body copy.
- **Header**: Minimalist logo-only circular emblem with 5 core navigation links and a high-visibility *Plant a Tree* CTA button.
- **Hero**: Clean, immersive visual typography over Western Ghats ancient canopy imagery with zero clutter.

---

## 📂 Site Structure

- **`/` (`index.html`)**: Interactive Home experience featuring trust vitals counters (250,000+ native canopy trees, 18,400+ elders supported), living programs overview, 80G tree dedication calculator, and field notes snippet.
- **`/about-us/`**: 18-year heritage, foundation pillars, board of trustees, and statutory transparency (80G, 12A, MCA CSR-1).
- **`/living-programs/`**: Detailed breakdown of Village Native Tree Plantation Drives, Apartment & Gated Community Greening, Elder Nature Respite Retreats, and Indigenous Seed Custody.
- **`/blog/` & `/blog/post.html`**: Dynamic field notes repository with category filtering, search, and reader view.
- **`/contact-and-visit/`**: Sanctuary grounds visitor guides, accessibility notes, direct bank transfer details (NEFT/RTGS), and reservation desk.
- **`/api/`**: RESTful PHP backend endpoints (`content.php`, `blogs.php`, `seo.php`, `upload.php`) connected to JSON flat-file storage in `api/data/`.
- **`.htaccess`**: Optimized LiteSpeed/Apache configuration with HTTPS enforcement, asset caching, Gzip compression, and security headers.
- **`sitemap.xml` & `robots.txt`**: Complete search engine crawler directives.

---

## 🚀 Deployment Instructions (Hostinger / Apache / LiteSpeed)

1. Clone or extract this repository into your web server's `public_html` directory:
   ```bash
   git clone https://github.com/samachakri/nature-care-trust-website.git public_html
   ```
2. Ensure directory permissions:
   - Folders: `755`
   - Files: `644`
   - Ensure `api/data/` and `assets/images/` are writable by the web server process.
3. Access your site live at `https://naturecaretrust.com/`.

---

## 📜 Statutory Details
- **Registration**: Public Charitable Trust Reg. No. `E-21448`
- **Income Tax Exemption**: Section 80G (`AAATN1843RF20214`) & Section 12A
- **CSR Registration**: Ministry of Corporate Affairs (`CSR00018942`)
