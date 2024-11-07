// Hamburger Menu Start
const tombol = document.querySelector(".tombol");
const menu = document.querySelector(".menu-navbar");

tombol.addEventListener("click", () => {
  menu.classList.toggle("aktif");
});
// Hamburger Menu END

// Header STRART
let currentIndex = 0;
const slides = document.querySelectorAll(".carousel-slide");
const totalSlides = slides.length;

function showSlide(index) {
  const carousel = document.querySelector(".carousel");
  carousel.style.transform = `translateX(-${index * 100}%)`;
}

function nextSlide() {
  currentIndex = (currentIndex + 1) % totalSlides;
  showSlide(currentIndex);
}

setInterval(nextSlide, 5000);
// Header END
