(function () {
  document.querySelectorAll('.video-cover').forEach(function (cover) {
    const container = cover.parentElement;
    const video = container.querySelector('video');
    const error = container.querySelector('.video-load-error');
    if (!video) return;
    cover.hidden = false;
    function restoreCover() {
      cover.hidden = false;
      error.hidden = false;
      cover.focus();
    }
    cover.addEventListener('click', function () {
      error.hidden = true;
      cover.hidden = true;
      video.focus();
      try {
        const playing = video.play();
        if (playing && playing.catch) playing.catch(restoreCover);
      } catch (e) {
        restoreCover();
      }
    });
    video.addEventListener('play', function () { cover.hidden = true; error.hidden = true; });
    video.addEventListener('ended', function () { cover.hidden = false; });
    video.addEventListener('error', restoreCover);
  });
})();
