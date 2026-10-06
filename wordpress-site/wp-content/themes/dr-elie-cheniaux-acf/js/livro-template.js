// Generic active-tab-on-scroll for the "livro" single template.
// Reads the sections directly from the .inner-tab links present on the page,
// so it works for any book regardless of which sections it has (sinopse/prefacio/comprar/outros-livros).
(function () {
  const tabs = document.querySelectorAll('.inner-tab');
  const sections = Array.from(tabs).map(t => t.getAttribute('href').replace('#', ''));
  function updateTabs() {
    let cur = '';
    sections.forEach(id => {
      const el = document.getElementById(id);
      if (el && el.getBoundingClientRect().top <= 130) cur = id;
    });
    tabs.forEach(t => {
      t.classList.toggle('active', t.getAttribute('href') === '#' + cur);
    });
  }
  window.addEventListener('scroll', updateTabs, { passive: true });
  updateTabs();
})();
