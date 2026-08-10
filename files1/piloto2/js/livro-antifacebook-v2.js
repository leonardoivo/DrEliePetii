// Active inner-tab on scroll
const sections = ['sinopse', 'comprar', 'outros-livros'];
const tabs = document.querySelectorAll('.inner-tab');
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
