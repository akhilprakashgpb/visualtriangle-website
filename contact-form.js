(function () {
  const form = document.querySelector('[data-contact-form]');
  if (!form) return;
  const status = form.querySelector('[data-contact-status]');
  const button = form.querySelector('[data-contact-submit]');
  let submitting = false;
  function showStatus(message, failed) {
    status.style.display = 'block';
    status.style.color = failed ? '#ffb4a1' : '#ddd';
    status.textContent = message;
  }
  form.addEventListener('submit', async function (event) {
    event.preventDefault();
    if (submitting || !form.reportValidity()) return;
    const data = new FormData(form);
    if (!String(data.get('full_name') || '').trim() || !String(data.get('brief') || '').trim()) {
      showStatus('Please enter your name and project brief.', true);
      return;
    }
    submitting = true;
    button.disabled = true;
    form.setAttribute('aria-busy', 'true');
    showStatus('Sending your enquiry…', false);
    try {
      const response = await fetch('/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams(data).toString()
      });
      if (!response.ok) throw new Error('Submission rejected');
      form.reset();
      showStatus('Thank you! Your enquiry has been submitted. We’ll be in touch soon.', false);
    } catch (error) {
      showStatus('We couldn’t submit your enquiry. Please try again, or email vt.visualtriangle@gmail.com.', true);
    } finally {
      submitting = false;
      button.disabled = false;
      form.removeAttribute('aria-busy');
    }
  });
})();
