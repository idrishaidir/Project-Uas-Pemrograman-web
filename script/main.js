// NAVBAR START
document.addEventListener("DOMContentLoaded", function () {
  fetch("navbar.html")
    .then((response) => response.text())
    .then((data) => {
      document.getElementById("navbar-container").innerHTML = data;

      // Seleksi elemen tombol dan menu setelah navbar dimuat
      const tombol = document.querySelector(".tombol");
      const menu = document.querySelector(".menu-navbar");

      tombol.addEventListener("click", () => {
        menu.classList.toggle("aktif");
      });
    });
});
// NAVBAR END

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

function prevSlide() {
  currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
  showSlide(currentIndex);
}

setInterval(nextSlide, 5000);

// Header END

document.addEventListener("DOMContentLoaded", function () {
  const toggleButtons = document.querySelectorAll(".toggle-content");

  // Fungsionalitas tombol "Baca Selengkapnya"
  toggleButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const content = this.previousElementSibling;
      if (content.classList.contains("hide")) {
        content.classList.remove("hide");
        this.textContent = "Tutup";
      } else {
        content.classList.add("hide");
        this.textContent = "Baca Selengkapnya";
      }
    });
  });
});

window.fbAsyncInit = function () {
  FB.init({
    appId: "https://www.facebook.com/",
    cookie: true,
    xfbml: true,
    version: "v13.0",
  });

  FB.getLoginStatus(function (response) {
    statusChangeCallback(response);
  });
};

function statusChangeCallback(response) {
  console.log("Status login: " + response.status);

  if (response.status === "connected") {
    console.log("Login berhasil!");
  } else {
    console.log("Login gagal!");
  }
}
