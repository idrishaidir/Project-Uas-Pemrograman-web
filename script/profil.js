function showContent(section) {
  var contents = document.querySelectorAll(".content");
  // var lobby = document.querySelectorAll(".profil-lobby");
  contents.forEach(function (content) {
    content.classList.remove("active");
  });
  document.getElementById(section).classList.add("active");

  // UNTUK MENGHILANGKAN LOBBY DEFAULT PROFIL SAAT MENGKLIK SIDEBAR
  document.getElementById("lobby").style.display = "none";
}
// Section Profile End

// SLIDE LAPANGAN START
let slideIndex = 1;
tampilSlide(slideIndex);

// Next/previous Lapanagan controls
function geserSlide(n) {
  tampilSlide((slideIndex += n));
}

// Thumbnail image Lapangan controls
function buletSlide(n) {
  tampilSlide((slideIndex = n));
}

function tampilSlide(n) {
  let i;
  let slideLapangan = document.getElementsByClassName("slide");
  let biji = document.getElementsByClassName("biji");
  if (n > slideLapangan.length) {
    slideIndex = 1;
  }
  if (n < 1) {
    slideIndex = slideLapangan.length;
  }
  for (i = 0; i < slideLapangan.length; i++) {
    slideLapangan[i].style.display = "none";
  }
  for (i = 0; i < biji.length; i++) {
    biji[i].className = biji[i].className.replace(" active-slide", "");
  }
  slideLapangan[slideIndex - 1].style.display = "block";
  biji[slideIndex - 1].className += " active-slide";
}
// SLIDE LAPANGAN END

// SLIDE LABORATURIUM START
let slideIndexLab = 1;
tampilSlideLab(slideIndexLab);

// Next/previous Lab controls
function geserSlideLab(n) {
  tampilSlideLab((slideIndexLab += n));
}

// Thumbnail image Lab controls
function buletSlideLab(n) {
  tampilSlideLab((slideIndexLab = n));
}

function tampilSlideLab(n) {
  let i;
  let slideLab = document.getElementsByClassName("slide-Lab");
  let bijiLab = document.getElementsByClassName("biji-Lab");
  if (n > slideLab.length) {
    slideIndexLab = 1;
  }
  if (n < 1) {
    slideIndexLab = slideLab.length;
  }
  for (i = 0; i < slideLab.length; i++) {
    slideLab[i].style.display = "none";
  }
  for (i = 0; i < bijiLab.length; i++) {
    bijiLab[i].className = bijiLab[i].className.replace(" active-Lab", "");
  }
  slideLab[slideIndexLab - 1].style.display = "block";
  bijiLab[slideIndexLab - 1].className += " active-Lab";
}
// SLIDE LABORATURIUM END

// SLIDE PERPUS START
let slideIndexPerpus = 1;
tampilSlidePerpus(slideIndexPerpus);

// Next/previous perpus controls
function geserSlidePerpus(n) {
  tampilSlidePerpus((slideIndexPerpus += n));
}

// Thumbnail image perpus controls
function buletSlidePerpus(n) {
  tampilSlidePerpus((slideIndexPerpus = n));
}

function tampilSlidePerpus(n) {
  let i;
  let slidePerpus = document.getElementsByClassName("slide-Perpus");
  let bijiPerpus = document.getElementsByClassName("biji-Perpus");
  if (n > slidePerpus.length) {
    slideIndexPerpus = 1;
  }
  if (n < 1) {
    slideIndexPerpus = slidePerpus.length;
  }
  for (i = 0; i < slidePerpus.length; i++) {
    slidePerpus[i].style.display = "none";
  }
  for (i = 0; i < bijiPerpus.length; i++) {
    bijiPerpus[i].className = bijiPerpus[i].className.replace(
      " active-Perpus",
      ""
    );
  }
  slidePerpus[slideIndexPerpus - 1].style.display = "block";
  bijiPerpus[slideIndexPerpus - 1].className += " active-Perpus";
}
// SLIDE PERPUS END
