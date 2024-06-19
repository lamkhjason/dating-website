document.addEventListener('DOMContentLoaded', function () {
  let carousel = document.querySelector('#pictureCarousel');
  let items = carousel.querySelectorAll('.profile-pic');
  let currentIndex = 0;

  function showSlide(index) {
  items.forEach((item, i) => {
    item.classList.toggle('active', i === index);
  });
  }

  function nextSlide() {
    currentIndex = (currentIndex + 1) % items.length;
    showSlide(currentIndex);
  }

  function prevSlide() {
    currentIndex = (currentIndex - 1 + items.length) % items.length;
    showSlide(currentIndex);
  }

  document.querySelector('.next-btn').addEventListener('click', nextSlide);
  document.querySelector('.prev-btn').addEventListener('click', prevSlide);
});