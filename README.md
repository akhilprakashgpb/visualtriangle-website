# Visual Triangle — Website

The approved nine-page redesign. Plain HTML, CSS and JavaScript, with no build step or dependencies.

## Preview

From the repository root, run `python3 -m http.server 8000` (Windows: `py -m http.server 8000`) and open http://localhost:8000. A web server is required because navigation and media use root-relative URLs.

## Hosting

Publish the repository root. The site includes both directory routes (`/about/`) and flat HTML aliases (`/about.html`). Images and all 19 video files are stored in `assets/`; playback does not depend on the previous website.

## Pages

Home, About, Services, Industries, Portfolio, CEO, Leadership & Creative Council, Insights, and Contact.

## Editing

Edit the HTML, `styles.css`, `redesign.css`, `script.js`, and `app.js` directly. When editing an inner page, keep its flat HTML alias and directory `index.html` in sync. Shared navigation and footer markup appears on each page.

The `_generator_source` directory is retained as a legacy reference. It predates this redesign; running it will not reproduce these approved pages.

## Contact

The enquiry form opens a prefilled email draft, matching the existing website. It does not send mail through a server. The legacy `contact.php` file is retained but is not used by this form.
