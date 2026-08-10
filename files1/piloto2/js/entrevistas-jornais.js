// Year filter
function filterYear(btn, year) {
  document.querySelectorAll('.filter-btn').forEach(b => {
    b.style.background = '#f3f0e8'; b.style.color = 'var(--navy)';
  });
  btn.style.background = 'var(--navy)'; btn.style.color = 'white';
  const cards = document.querySelectorAll('#cards-grid article');
  let visible = 0;
  cards.forEach(c => {
    const show = year === 'todos' || c.dataset.year === year;
    c.style.display = show ? '' : 'none';
    if (show) visible++;
  });
  document.getElementById('empty-state').classList.toggle('hidden', visible > 0);
}
