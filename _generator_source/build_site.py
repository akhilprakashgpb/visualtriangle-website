import os

OUT = "/home/claude/vt_site/site"

# Leadership & CEO are intentionally left out of the primary menu (per request)
# but the pages still exist and are linked from the Home page and footer.
NAV_ITEMS = [
    ("01", "Home", "index.html"),
    ("02", "About", "about.html"),
    ("03", "Services", "services.html"),
    ("04", "Industries", "industries.html"),
    ("05", "Portfolio", "portfolio.html"),
    ("06", "Insights", "insights.html"),
    ("07", "Contact", "contact.html"),
]

def nav_links_html(current):
    items = []
    for idx, label, href in NAV_ITEMS:
        items.append(f'<li><a href="{href}"><span class="idx">{idx}</span>{label}</a></li>')
    return "\n".join(items)

def head(title, desc):
    return f"""<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title} — Visual Triangle Media Services</title>
<meta name="description" content="{desc}">
<link rel="icon" href="assets/vt_icon_black.png">
<link rel="stylesheet" href="styles.css">
</head>
<body>
"""

def nav_and_overlay(current):
    return f"""
<nav class="nav">
  <a href="index.html" class="nav-left">
    <img src="assets/vt_icon.png" class="nav-logo" alt="Visual Triangle">
    <span class="nav-word">Visual Triangle</span>
  </a>
  <div class="nav-right">
    <span class="timecode" data-timecode>00:00:00:00</span>
    <button class="menu-btn" data-menu-open>
      <span class="bars"><span></span><span></span></span>
      Menu
    </button>
  </div>
</nav>

<div class="nav-overlay" data-nav-overlay>
  <div class="nav-overlay-top">
    <a href="index.html" class="nav-left">
      <img src="assets/vt_icon.png" class="nav-logo" alt="Visual Triangle">
      <span class="nav-word">Visual Triangle</span>
    </a>
    <button class="nav-overlay-close" data-menu-close>Close &times;</button>
  </div>
  <ul class="nav-links">
    {nav_links_html(current)}
  </ul>
  <div class="nav-overlay-foot">
    <a href="mailto:contact@visualtriangle.com">contact@visualtriangle.com</a>
    <a href="mailto:vt.visualtriangle@gmail.com">vt.visualtriangle@gmail.com</a>
    <a href="tel:+919526557818">+91 95265 57818</a>
    <span>Thrissur, Kerala, India</span>
    <span>Since 2021</span>
  </div>
</div>
"""

def footer():
    return """
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-brand">
      <img src="assets/vt_logo.png" class="footer-logo" alt="Visual Triangle Media Services">
      <p>A premium creative studio combining cinematic storytelling with strategic communication, for engineering, technology and enterprise brands.</p>
    </div>
    <div class="footer-col">
      <h4>Studio</h4>
      <a href="about.html">About</a>
      <a href="services.html">Services</a>
      <a href="industries.html">Industries</a>
      <a href="portfolio.html">Portfolio</a>
    </div>
    <div class="footer-col">
      <h4>People</h4>
      <a href="ceo.html">CEO</a>
      <a href="leadership.html">Leadership &amp; Creative Council</a>
      <a href="insights.html">Insights</a>
    </div>
    <div class="footer-col">
      <h4>Contact</h4>
      <a href="mailto:contact@visualtriangle.com">contact@visualtriangle.com</a>
      <a href="mailto:vt.visualtriangle@gmail.com">vt.visualtriangle@gmail.com</a>
      <a href="tel:+919526557818">+91 95265 57818</a>
      <p>69/2, Sreenilayam, Thalore,<br>Thrissur, Kerala, India&nbsp;680306</p>
    </div>
  </div>
  <div class="footer-bottom">
    <span>&copy; <span data-year>2026</span> Visual Triangle Media Services</span>
    <span>Since 2021 — Thrissur, Kerala</span>
  </div>
</footer>
<script src="script.js"></script>
</body>
</html>
"""

def write_page(filename, title, desc, current, body):
    html = head(title, desc) + nav_and_overlay(current) + body + footer()
    with open(os.path.join(OUT, filename), "w") as f:
        f.write(html)
    print("wrote", filename, len(html), "bytes")
