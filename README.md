# Pi Dentist — WordPress Child Theme

> Website chỉnh nha chuyên sâu · **pidentist.vn**

**Stack:** WordPress 6.4+ · GeneratePress (parent) · Block Patterns · CPT native · Vanilla JS

---

## Quick Start

1. Install [LocalWP](https://localwp.com/) → create site `pidentist.local`
2. Activate **GeneratePress** parent theme
3. Clone repo → symlink/copy to `wp-content/themes/pidentist`
4. Activate child theme from **Appearance → Themes**
5. **Settings → Permalinks** → `/%postname%/` → Save

## Structure

```
pidentist/
├── inc/              # PHP modules (1 file = 1 concern)
├── assets/
│   ├── css/          # CSS files — tokens.css as foundation
│   │   └── patterns/ # Pattern-specific CSS (conditional load)
│   ├── js/           # Vanilla JS, NO jQuery
│   ├── fonts/        # Self-hosted woff2
│   └── images/       # Theme images
├── template-parts/   # Reusable template fragments
│   ├── header/       # site-branding, nav-mobile
│   ├── footer/       # footer-brand, footer-links, footer-bottom
│   ├── card/         # service, doctor, case, post cards
│   ├── section/      # section-header, booking-cta, page-hero
│   └── floating/     # cta, contact-widgets, back-to-top
├── docs/             # Project specs & phase prompts
└── deploy/           # VPS deployment scripts
```

## Design System

| Token | Value |
|-------|-------|
| Primary | `#002147` (Navy) |
| Accent | `#C9A96E` (Gold) |
| Heading font | Playfair Display |
| Body font | Inter |
| Container | 1200px max-width |
| Border radius | 16px cards · 6px buttons |

## Custom Post Types

| CPT | Archive URL | REST base |
|-----|------------|-----------|
| `pi_service` | `/dich-vu/` | `services` |
| `pi_doctor` | `/bac-si/` | `doctors` |
| `pi_case` | `/case/` | `cases` |

## Development Rules

- **No jQuery** — Vanilla JS only
- **No ACF** — native `register_post_meta()` + meta boxes
- **No page builders** — Block Editor + Block Patterns
- **CSS custom properties** — never hardcode colors/fonts
- **1 file = 1 concern** — logic goes in `inc/`, not `functions.php`
- **Mobile-first** — base styles for mobile, `@media (min-width)` for larger

## Phases

| Phase | Description |
|-------|-------------|
| 0 | LocalWP + child theme skeleton + Git ✅ |
| 1 | Convert HTML → header/footer/floating/CSS/JS |
| 2 | CPT + Taxonomies + Meta + Templates |
| 3 | Block Patterns + Homepage compose |
| 4 | Plugin stack + SEO + Security |
| 5 | Deploy VPS + Nginx + SSL + Cloudflare |
| 6 | Content + Polish + Go-live |

## License

Private — All rights reserved © Pi Dentist
