# Visual Triangle Media Services — Website

A 9-page static site: plain HTML/CSS/JS, no build step, no framework. Open
`index.html` in a browser, or deploy the whole `site/` folder as-is to any
static host (Netlify, Vercel, GitHub Pages, S3, cPanel — anything that
serves static files).

## Pages

| Page | File |
|---|---|
| Home | `index.html` |
| About | `about.html` |
| Services | `services.html` |
| Industries | `industries.html` |
| Portfolio | `portfolio.html` |
| Leadership & Creative Council | `leadership.html` |
| CEO | `ceo.html` |
| Insights | `insights.html` |
| Contact | `contact.php` |

## Design direction

Reference points: Apple (restraint, huge type, precise spacing), SpaceX
(bold grotesk headlines, dark full-bleed sections, mission confidence),
A24 (cinematic stills, generous whitespace). Pure black/white/gray — no
accent color anywhere, by request.

- **Display type**: Inter Tight (700–900) — big, tight-tracked headlines.
- **Body type**: Inter.
- **Utility/mono**: JetBrains Mono — eyebrows, index numbers, the nav
  timecode.
- **Signature element**: a running edit-timecode (`00:00:00:00`, 24fps) in
  the top nav. Visual Triangle's identity is "engineering precision,
  cinematic storytelling" — a timecode is the one instrument that measures
  both a film and a piece of engineering.
- Fonts load from Google Fonts via a CDN `@import` in `styles.css` — this
  needs an internet connection to render exactly as designed. If you need
  it to work fully offline, download the three font families and swap the
  `@import` for local `@font-face` rules.

## Content sources

- Company description, mission/vision, services, industries, portfolio
  categories: `Visual_Triangle_Website_Structure.pdf` (primary) and
  `Visual_Triangle_Presentation.pdf` (supporting detail).
- Photography, team photos, and all 16 client logos: extracted directly
  from `Visual_Triangle_Presentation.pdf` at full resolution, then
  cropped/compressed for web (see `assets/`).
- CEO bio: the presentation deck's bio only ("Founder & CEO, Professional
  Film Editor, 14 years of experience..."). **Your Canva site
  (akhilprakash.my.canva.site) could not be read** — it's a JavaScript-
  rendered page my fetch tools can't extract text from, and I don't have
  browser access in this session. If you paste the bio text directly, I
  can drop it straight into `ceo.html`.
- Leadership & Creative Council bios: written from each person's Wikipedia
  page (linked in your message), fact-checked against it, and paraphrased
  into original site copy — not copied verbatim.
- Portfolio and Insights pages: the structure PDF lists categories/topics
  only, not actual projects or articles, so both pages are built as
  honest placeholders (category grid + "request our reel" / "coming soon")
  rather than inventing fake project names or blog posts. Swap in real
  work whenever you have it.

## Known gaps to fill in

1. **CEO page** — send the Canva bio text and I'll merge it in.
2. **Contact form** — the form on `contact.php` now posts to the same page
  and sends mail to `dileep.cherat@gmail.com` through PHP's `mail()`
  function. Delivery requires a real hosting environment with PHP mail
  configured correctly.
3. **Portfolio** — category cards link to Contact for now; swap in real
   case studies/reels when ready.
4. **Favicon** — using the triangle mark at `assets/vt_icon.png`; replace
   with a proper multi-size favicon set if you want full browser/OS
   coverage.

## Editing

Everything is plain HTML/CSS — no templating engine. Nav and footer are
duplicated across all 9 files (by design, for zero-dependency hosting).
If you're using Claude Code or another dev tool to keep editing this, the
Python files (`build_site.py`, `pages_*.py`, `generate.py`) in the parent
folder are the *source* — they assemble the shared nav/footer plus each
page's content into the final HTML. Edit those and re-run `generate.py`
rather than hand-editing all 9 HTML files individually for shared changes
(like nav links or the footer).
