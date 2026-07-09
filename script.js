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
})();
