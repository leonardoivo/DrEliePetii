function toggleCV(header) {
  const body = header.nextElementSibling;
  const arrow = header.querySelector('.cv-arrow');
  body.classList.toggle('open');
  arrow.style.transform = body.classList.contains('open') ? 'rotate(180deg)' : '';
}
