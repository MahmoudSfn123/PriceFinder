function smoothScrollTo(id) {
  // Enable smooth scroll
  document.documentElement.classList.add('smooth-scroll');
  document.body.classList.add('smooth-scroll');

  // Scroll to target
  const el = document.getElementById(id);
  if (el) el.scrollIntoView();

  // Optional: Remove smooth-scroll after scroll finishes
  setTimeout(() => {
    document.documentElement.classList.remove('smooth-scroll');
    document.body.classList.remove('smooth-scroll');
  }, 500); // Wait enough time for smooth scroll to finish
}
