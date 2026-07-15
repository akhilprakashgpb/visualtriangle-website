// ===================================================================
// VISUAL TRIANGLE — shared behavior
// ===================================================================

(function(){
  // ---- running timecode (HH:MM:SS:FF @ 24fps) — page-session based ----
  var tcEl = document.querySelector('[data-timecode]');
  if (tcEl && !window.matchMedia('(prefers-reduced-motion: reduce)').matches){
    var start = performance.now();
    function pad(n,l){ l=l||2; return String(n).padStart(l,'0'); }
    function tick(){
      var elapsed = (performance.now() - start) / 1000;
      var fps = 24;
      var totalFrames = Math.floor(elapsed * fps);
      var ff = totalFrames % fps;
      var totalSeconds = Math.floor(elapsed);
      var ss = totalSeconds % 60;
      var mm = Math.floor(totalSeconds/60) % 60;
      var hh = Math.floor(totalSeconds/3600);
      tcEl.textContent = pad(hh)+':'+pad(mm)+':'+pad(ss)+':'+pad(ff);
      requestAnimationFrame(tick);
    }
    requestAnimationFrame(tick);
  } else if (tcEl){
    tcEl.textContent = '00:00:00:00';
  }

  // ---- nav overlay ----
  var menuBtn = document.querySelector('[data-menu-open]');
  var closeBtn = document.querySelector('[data-menu-close]');
  var overlay = document.querySelector('[data-nav-overlay]');
  function openNav(){
    overlay.classList.add('open');
    document.body.classList.add('nav-open');
  }
  function closeNav(){
    overlay.classList.remove('open');
    document.body.classList.remove('nav-open');
  }
  if (menuBtn) menuBtn.addEventListener('click', openNav);
  if (closeBtn) closeBtn.addEventListener('click', closeNav);
  if (overlay){
    overlay.querySelectorAll('a').forEach(function(a){
      a.addEventListener('click', closeNav);
    });
  }
  document.addEventListener('keydown', function(e){
    if (e.key === 'Escape') closeNav();
  });

  // ---- scroll reveal ----
  var revealEls = document.querySelectorAll('.reveal');
  if ('IntersectionObserver' in window && revealEls.length){
    var io = new IntersectionObserver(function(entries){
      entries.forEach(function(entry){
        if (entry.isIntersecting){
          entry.target.classList.add('in');
          io.unobserve(entry.target);
        }
      });
    }, {threshold:0.12, rootMargin:'0px 0px -60px 0px'});
    revealEls.forEach(function(el){ io.observe(el); });
  } else {
    revealEls.forEach(function(el){ el.classList.add('in'); });
  }

  // ---- current year in footer ----
  var yearEl = document.querySelector('[data-year]');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  // ---- insights: topic box opens the matching article and scrolls to it ----
  document.querySelectorAll('.insight-box[data-target]').forEach(function(box){
    box.addEventListener('click', function(e){
      var targetId = box.getAttribute('data-target');
      var target = document.getElementById(targetId);
      if (!target) return;
      e.preventDefault();
      document.querySelectorAll('details.insight-article[open]').forEach(function(d){
        if (d !== target) d.removeAttribute('open');
      });
      target.setAttribute('open', '');
      window.setTimeout(function(){
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }, 30);
    });
  });

  // ---- contact form: temporary mailto-only flow (FormSubmit is unstable) ----
  var contactForm = document.querySelector('[data-contact-form]');
  if (contactForm) {
    var contactStatus = contactForm.querySelector('[data-contact-status]');
    var contactSubmit = contactForm.querySelector('[data-contact-submit]');

    function setContactStatus(message, isError) {
      if (!contactStatus) return;
      contactStatus.style.display = 'block';
      contactStatus.style.color = isError ? '#a3381b' : 'var(--ink)';
      contactStatus.textContent = message;
    }

    function openMailtoDraft(fullName, company, email, phone, service, brief) {
      var subject = 'New project enquiry from Visual Triangle website';
      var bodyLines = [
        'New project enquiry details:',
        '',
        'Full Name: ' + fullName,
        'Company / Brand: ' + (company || 'Not provided'),
        'Email Address: ' + email,
        'Phone Number: ' + (phone || 'Not provided'),
        'Service Needed: ' + (service || 'Not specified'),
        '',
        'Project Brief:',
        brief
      ];

      var mailtoUrl = 'mailto:vt.visualtriangle@gmail.com'
        + '?cc=' + encodeURIComponent('dileep.cherat@gmail.com,akhilprakashgpb@gmail.com')
        + '&subject=' + encodeURIComponent(subject)
        + '&body=' + encodeURIComponent(bodyLines.join('\n'));

      window.location.href = mailtoUrl;
    }

    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();

      var formData = new FormData(contactForm);
      var fullName = String(formData.get('full_name') || '').trim();
      var company = String(formData.get('company') || '').trim();
      var email = String(formData.get('email') || '').trim();
      var phone = String(formData.get('phone') || '').trim();
      var service = String(formData.get('service') || '').trim();
      var brief = String(formData.get('brief') || '').trim();
      var websiteTrap = String(formData.get('website') || '').trim();

      if (websiteTrap !== '') {
        setContactStatus('Thanks for your inquiry. We will get back to you shortly.', false);
        contactForm.reset();
        return;
      }

      if (!fullName) {
        setContactStatus('Full name is required.', true);
        return;
      }

      if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        setContactStatus('A valid email address is required.', true);
        return;
      }

      if (!brief) {
        setContactStatus('Project brief is required.', true);
        return;
      }

      if (contactSubmit) contactSubmit.disabled = true;

      setContactStatus('Opening your email app to send this enquiry.', false);
      openMailtoDraft(fullName, company, email, phone, service, brief);

      if (contactSubmit) contactSubmit.disabled = false;
    });
  }
})();
