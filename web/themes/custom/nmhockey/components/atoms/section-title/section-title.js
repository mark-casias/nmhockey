const sectionTitleToggle = document.querySelector('.section-title--collapse');
console.log(sectionTitleToggle);
sectionTitleToggle.addEventListener('click', function(event) {
  sectionTitleToggle.classList.toggle('section-title--closed');
});
