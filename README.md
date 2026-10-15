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

The enquiry form submits to Netlify Forms (`project-enquiry`) with a honeypot. Visitors receive inline confirmation after a successful response; without JavaScript, they are redirected to `/thank-you/`. Failed submissions preserve the entered text for retry. The legacy `contact.php` file is not used.

Before merging/deploying, open the Netlify project serving visualtriangle.com and enable **Forms → Enable form detection**. After deployment, verify that `project-enquiry` is listed. Under **Forms → Submission notifications → Add notification → Email notification**, enter `vt.visualtriangle@gmail.com` and select this form. Submit a real test enquiry and confirm it appears in Forms and arrives in the inbox.

Email notification recipients are configured in Netlify, not in the HTML. This code change cannot enable dashboard settings or verify delivery. Ordinary local static servers and non-Netlify hosting do not process these submissions.
