// ===== Base behavior shared across all pages =====

// Mobile menu (hamburger)
document.getElementById('hamburger').addEventListener('click', () => document.getElementById('mobile-menu').classList.toggle('open'));
document.getElementById('close-menu').addEventListener('click', () => document.getElementById('mobile-menu').classList.remove('open'));
function toggleMob(id) { document.getElementById(id).classList.toggle('open'); }

// Scroll reveal
const obs = new IntersectionObserver(e => e.forEach(x => { if (x.isIntersecting) x.target.classList.add('visible'); }), { threshold: .1 });
document.querySelectorAll('.reveal').forEach(r => obs.observe(r));

// Category filter (used by pages with a .filter-btn / #cards-grid list)
function filterCat(btn, cat) {
  document.querySelectorAll('.filter-btn').forEach(b => { b.style.background = '#f3f0e8'; b.style.color = 'var(--navy)'; });
  btn.style.background = 'var(--navy)'; btn.style.color = 'white';
  const cards = document.querySelectorAll('#cards-grid article');
  let v = 0;
  cards.forEach(c => { const show = cat === 'todos' || c.dataset.cat === cat; c.style.display = show ? '' : 'none'; if (show) v++; });
  document.getElementById('empty-state').classList.toggle('hidden', v > 0);
}
