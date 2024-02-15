const slides_2 = document.querySelectorAll('.slide_2');
let currentSlide_2 = 0;
function showSlide_2(n) {
  slides_2[currentSlide_2].classList.remove('active_2');
  currentSlide_2 = (n + slides_2.length) % slides_2.length;
  slides_2[currentSlide_2].classList.add('active_2');
}
function nextSlide_2() {
  showSlide_2(currentSlide_2 + 1);
}
function prevSlide_2() {
  showSlide_2(currentSlide_2 - 1);
}
setInterval(nextSlide_2, 10000);
const prevButton = document.querySelector('.prev_button-2');
const nextButton = document.querySelector('.next_button-2');
prevButton.addEventListener('click', prevSlide_2);
nextButton.addEventListener('click', nextSlide_2);