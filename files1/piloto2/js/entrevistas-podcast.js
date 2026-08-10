function filterP(btn, theme) {
  document.querySelectorAll('.filter-btn').forEach(b => { b.style.background = '#f3f0e8'; b.style.color = 'var(--navy)'; });
  btn.style.background = 'var(--navy)'; btn.style.color = 'white';
  const cards = document.querySelectorAll('#cards-grid article');
  let v = 0;
  cards.forEach(c => { const show = theme === 'todos' || c.dataset.theme === theme; c.style.display = show ? '' : 'none'; if (show) v++; });
  document.getElementById('empty-state').classList.toggle('hidden', v > 0);
}
