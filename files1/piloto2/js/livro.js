// ===== Shared behavior for the non-v2 book pages =====
// Highlight active in-page tab (sinopse/prefacio/comprar/outros-livros) on scroll

const sections = ['sinopse', 'prefacio', 'comprar', 'outros-livros'];
const tabs = document.querySelectorAll('.inner-tab');
window.addEventListener('scroll', () => {
  let cur = '';
  sections.forEach(id => { const el = document.getElementById(id); if (el && el.getBoundingClientRect().top <= 120) cur = id; });
  tabs.forEach(t => { t.classList.toggle('active', t.getAttribute('href') === '#' + cur); });
});
