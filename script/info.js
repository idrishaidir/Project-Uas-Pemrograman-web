document.addEventListener("DOMContentLoaded", () => {
  let currentSlide = 0;

  // Fungsi untuk memperbarui posisi carousel
  function updateCarousel() {
    const carousel = document.querySelector(".carousel");
    carousel.style.transform = `translateX(-${currentSlide * 100}%)`;
  }

  // Fungsi untuk pindah ke slide berikutnya
  function nextSlide() {
    const carousel = document.querySelector(".carousel");
    const totalSlides = carousel.children.length;
    currentSlide = (currentSlide + 1) % totalSlides;
    updateCarousel();
  }

  // Fungsi untuk pindah ke slide sebelumnya
  function prevSlide() {
    const carousel = document.querySelector(".carousel");
    const totalSlides = carousel.children.length;
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateCarousel();
  }

  // Fungsi untuk menampilkan konten sesuai ID
  function showContent(id) {
    // Sembunyikan semua elemen dengan class .content p
    document.querySelectorAll(".content p").forEach((element) => {
      element.classList.add("hidden");
    });

    // Tampilkan elemen yang sesuai ID
    document.getElementById(id).classList.remove("hidden");

    // Tambahkan animasi fade-in saat konten muncul
    const contentElement = document.getElementById(id);
    contentElement.style.opacity = 0;
    contentElement.style.transition = "opacity 0.5s ease-in-out";
    setTimeout(() => {
      contentElement.style.opacity = 1;
    }, 50);
  }

  // Tambahkan fungsi ke global scope
  window.nextSlide = nextSlide;
  window.prevSlide = prevSlide;
  window.showContent = showContent;

  // Inisialisasi posisi awal carousel
  updateCarousel();

  const menu = document.getElementById("menu");
  const nav = document.getElementById("nav");

  // Toggle menu
  menu.addEventListener("click", function () {
    menu.classList.toggle("open");
    nav.classList.toggle("visible");
  });
});

function filterBerita(kategori) {
  window.location.href =
    "info.php?kategori=" + encodeURIComponent(kategori) + "#berita-container";
}
