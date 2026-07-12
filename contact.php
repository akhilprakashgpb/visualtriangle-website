<?php
$contact_recipient = 'vt.visualtriangle@gmail.com';
$contact_cc = ['dileep.cherat@gmail.com', 'akhilprakashgpb@gmail.com'];
$status_message = '';
$status_type = '';
$form_values = [
  'full_name' => '',
  'company' => '',
  'email' => '',
  'phone' => '',
  'service' => '',
  'brief' => '',
  'website' => '',
];

function vtEscape($value) {
  return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

if (isset($_GET['sent']) && $_GET['sent'] === '1') {
  $status_type = 'success';
  $status_message = 'Thank you. Your enquiry has been sent and the studio will reply soon.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($form_values as $key => $value) {
    $form_values[$key] = trim((string) ($_POST[$key] ?? ''));
  }

  if ($form_values['website'] !== '') {
    header('Location: contact.php?sent=1');
    exit;
  }

  $errors = [];

  if ($form_values['full_name'] === '') {
    $errors[] = 'Full name is required.';
  }

  if ($form_values['email'] === '' || !filter_var($form_values['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
  }

  if ($form_values['brief'] === '') {
    $errors[] = 'Project brief is required.';
  }

  if (!$errors) {
    $safe_name = vtEscape($form_values['full_name']);
    $safe_company = vtEscape($form_values['company'] !== '' ? $form_values['company'] : 'Not provided');
    $safe_email = vtEscape($form_values['email']);
    $safe_phone = vtEscape($form_values['phone'] !== '' ? $form_values['phone'] : 'Not provided');
    $safe_service = vtEscape($form_values['service'] !== '' ? $form_values['service'] : 'Not specified');
    $safe_brief = nl2br(vtEscape($form_values['brief']));
    $submitted_at = date('d M Y, h:i A');
    $subject = 'New project enquiry from Visual Triangle website';
    $message_body = <<<HTML
<html>
  <body style="margin:0;padding:32px;background:#f5f1ea;font-family:Arial,sans-serif;color:#171717;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:720px;margin:0 auto;background:#ffffff;border:1px solid #ddd4c7;">
      <tr>
        <td style="padding:28px 32px;border-bottom:1px solid #ddd4c7;">
          <div style="font-size:12px;letter-spacing:0.18em;text-transform:uppercase;color:#6f6a63;">Visual Triangle Media Services</div>
          <h1 style="margin:14px 0 0;font-size:28px;line-height:1.2;color:#171717;">New Project Enquiry</h1>
          <p style="margin:12px 0 0;font-size:14px;line-height:1.7;color:#58524b;">A new enquiry was submitted through the website contact page.</p>
        </td>
      </tr>
      <tr>
        <td style="padding:28px 32px;">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            <tr>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;width:180px;">Full Name</td>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:16px;line-height:1.6;color:#171717;">{$safe_name}</td>
            </tr>
            <tr>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;">Company / Brand</td>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:16px;line-height:1.6;color:#171717;">{$safe_company}</td>
            </tr>
            <tr>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;">Email Address</td>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:16px;line-height:1.6;color:#171717;">{$safe_email}</td>
            </tr>
            <tr>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;">Phone Number</td>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:16px;line-height:1.6;color:#171717;">{$safe_phone}</td>
            </tr>
            <tr>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;">Service Needed</td>
              <td style="padding:12px 0;border-bottom:1px solid #eee7dc;font-size:16px;line-height:1.6;color:#171717;">{$safe_service}</td>
            </tr>
            <tr>
              <td style="padding:12px 0 0;font-size:13px;font-weight:bold;letter-spacing:0.08em;text-transform:uppercase;color:#6f6a63;vertical-align:top;">Project Brief</td>
              <td style="padding:12px 0 0;font-size:16px;line-height:1.8;color:#171717;">{$safe_brief}</td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td style="padding:20px 32px;background:#faf7f2;border-top:1px solid #ddd4c7;font-size:13px;line-height:1.7;color:#6f6a63;">
          Submitted on {$submitted_at}<br>
          Reply directly to this email to respond to {$safe_name}.
        </td>
      </tr>
    </table>
  </body>
</html>
HTML;

    $headers = [
      'MIME-Version: 1.0',
      'Content-Type: text/html; charset=UTF-8',
      'From: Visual Triangle Website <noreply@visualtriangle.com>',
      'Reply-To: ' . $form_values['email'],
      'Cc: ' . implode(', ', $contact_cc),
      'X-Mailer: PHP/' . phpversion(),
    ];

    if (mail($contact_recipient, $subject, $message_body, implode("\r\n", $headers))) {
      header('Location: contact.php?sent=1');
      exit;
    }

    $status_type = 'error';
    $status_message = 'The enquiry could not be sent right now. Please email vt.visualtriangle@gmail.com directly.';
  } else {
    $status_type = 'error';
    $status_message = implode(' ', $errors);
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Contact — Visual Triangle Media Services</title>
<meta name="description" content="Let's build something extraordinary — get in touch with Visual Triangle Media Services.">
<link rel="icon" href="assets/vt_icon_black.png">
<link rel="stylesheet" href="styles.css">
</head>
<body>

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
    <li><a href="index.html"><span class="idx">01</span>Home</a></li>
    <li><a href="about.html"><span class="idx">02</span>About</a></li>
    <li><a href="services.html"><span class="idx">03</span>Services</a></li>
    <li><a href="industries.html"><span class="idx">04</span>Industries</a></li>
    <li><a href="portfolio.html"><span class="idx">05</span>Portfolio</a></li>
    <li><a href="insights.html"><span class="idx">06</span>Insights</a></li>
    <li><a href="contact.php"><span class="idx">07</span>Contact</a></li>
  </ul>
  <div class="nav-overlay-foot">
    <a href="mailto:contact@visualtriangle.com">contact@visualtriangle.com</a>
    <a href="mailto:vt.visualtriangle@gmail.com">vt.visualtriangle@gmail.com</a>
    <a href="tel:+919526557818">+91 95265 57818</a>
    <span>Thrissur, Kerala, India</span>
    <span>Since 2021</span>
  </div>
</div>

<header class="section" style="padding-top:160px; padding-bottom:0;">
  <div class="wrap">
    <p class="eyebrow reveal">Contact</p>
    <h1 class="display-1 reveal" style="margin-top:22px; max-width:1000px;">Let's build something<br>extraordinary.</h1>
  </div>
</header>

<section class="section">
  <div class="wrap">
    <div class="grid grid-2" style="gap:56px;">
      <div class="reveal">
        <p class="eyebrow">Get in touch</p>
        <div style="margin-top:28px; display:flex; flex-direction:column; gap:22px;">
          <a href="mailto:contact@visualtriangle.com" class="text-link" style="font-family:var(--display); font-weight:700; font-size:clamp(22px,2.4vw,32px);">contact@visualtriangle.com</a>
          <a href="mailto:vt.visualtriangle@gmail.com" class="text-link" style="font-family:var(--display); font-weight:700; font-size:clamp(22px,2.4vw,32px);">vt.visualtriangle@gmail.com</a>
          <a href="tel:+919526557818" class="text-link" style="font-family:var(--display); font-weight:700; font-size:clamp(22px,2.4vw,32px);">+91 95265 57818</a>
          <a href="https://www.visualtriangle.com" class="text-link" style="font-family:var(--display); font-weight:700; font-size:clamp(22px,2.4vw,32px);">www.visualtriangle.com</a>
        </div>
        <div class="rule" style="margin:36px 0;"></div>
        <p class="eyebrow">Studio Address</p>
        <p class="lede" style="margin-top:16px; color:var(--ink);">69/2, Sreenilayam, Thalore,<br>Thrissur, Kerala, India&nbsp;680306</p>
      </div>

      <form class="reveal" action="contact.php" method="POST" accept-charset="UTF-8" style="display:flex; flex-direction:column; gap:20px;">
        <p class="eyebrow">Start a project</p>
        <?php if ($status_message !== ''): ?>
        <output data-contact-status aria-live="polite" style="display:block; font-family:var(--mono); font-size:12px; color:<?php echo $status_type === 'success' ? 'var(--ink)' : '#a3381b'; ?>;"><?php echo vtEscape($status_message); ?></output>
        <?php else: ?>
        <output data-contact-status aria-live="polite" style="display:none; font-family:var(--mono); font-size:12px; color:var(--gray);"></output>
        <?php endif; ?>
        <div style="position:absolute; left:-9999px; width:1px; height:1px; overflow:hidden;">
          <label for="contact-website">Website</label>
          <input id="contact-website" type="text" name="website" tabindex="-1" autocomplete="off" value="<?php echo vtEscape($form_values['website']); ?>">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-name" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Full Name</label>
          <input id="contact-name" type="text" name="full_name" autocomplete="name" required value="<?php echo vtEscape($form_values['full_name']); ?>" style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent;">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-company" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Company / Brand</label>
          <input id="contact-company" type="text" name="company" autocomplete="organization" value="<?php echo vtEscape($form_values['company']); ?>" style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent;">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-email" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Email Address</label>
          <input id="contact-email" type="email" name="email" autocomplete="email" required value="<?php echo vtEscape($form_values['email']); ?>" style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent;">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-phone" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Phone Number</label>
          <input id="contact-phone" type="tel" name="phone" autocomplete="tel" value="<?php echo vtEscape($form_values['phone']); ?>" style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent;">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-service" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Service Needed</label>
          <input id="contact-service" type="text" name="service" placeholder="Brand film, corporate video, editing, campaign launch..." value="<?php echo vtEscape($form_values['service']); ?>" style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent;">
        </div>
        <div style="display:flex; flex-direction:column; gap:6px;">
          <label for="contact-message" style="font-family:var(--mono); font-size:12px; letter-spacing:.08em; text-transform:uppercase; color:var(--gray);">Project Brief</label>
          <textarea id="contact-message" name="brief" rows="5" required style="border:none; border-bottom:1px solid var(--line-on-light); padding:12px 0; font-family:var(--body); font-size:17px; background:transparent; resize:vertical;"><?php echo vtEscape($form_values['brief']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-solid" style="align-self:flex-start; margin-top:8px;">Send Inquiry <span class="btn-arrow">&rarr;</span></button>
        <p style="font-family:var(--mono); font-size:12px; color:var(--gray-light);">Project enquiries are delivered to vt.visualtriangle@gmail.com.</p>
      </form>
    </div>
  </div>
</section>

<div class="figure reveal" style="height:56vh;">
  <img src="assets/photography/phone_desk.jpg" alt="Visual Triangle office desk" class="kicker-photo">
</div>

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
