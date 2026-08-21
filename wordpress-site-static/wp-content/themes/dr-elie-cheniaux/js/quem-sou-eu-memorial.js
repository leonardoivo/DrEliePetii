// Highlight chapter nav on scroll
const sections = document.querySelectorAll('section[id]');
const chLinks = document.querySelectorAll('.chapter-nav a');
window.addEventListener('scroll', () => {
  let cur = '';
  sections.forEach(s => { if (window.scrollY >= s.offsetTop - 180) cur = s.id; });
  chLinks.forEach(a => { a.classList.toggle('active', a.getAttribute('href') === '#' + cur); });
});
