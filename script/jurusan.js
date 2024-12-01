function showContent(section) {
    var contents = document.querySelectorAll(".hide");
    // var lobby = document.querySelectorAll(".profil-lobby");
    contents.forEach(function (content) {
        content.classList.remove("active-main");
    });
    document.getElementById(section).classList.add("active-main");

    // UNTUK MENGHILANGKAN LOBBY DEFAULT PROFIL SAAT MENGKLIK SIDEBAR
    document.getElementById("lobby").style.display = "none";
    document.getElementById("isi-lobby").style.display = "none";
}

function showIsi(isi) {
    var isiHalaman = document.querySelectorAll(".isi-halaman");
    // var lobby = document.querySelectorAll(".profil-lobby");
    isiHalaman.forEach(function (content) {
        content.classList.remove("active-isi");
    });
    document.getElementById(isi).classList.add("active-isi");
}

function showFootNav() {
    var lobbyNav = document.querySelector('.lobby-nav');
    var jurusanNav = document.querySelectorAll('.jurusan-nav');

    var jurusanNavVisible = Array.from(jurusanNav).some(function(nav) {
        return nav.style.display === "block";
    });

    if (jurusanNavVisible && (lobbyNav.style.display === "block")) {
        jurusanNav.forEach(function(nav) {
            nav.style.display = "none";
        });
        lobbyNav.style.display = "none";
    } else {
        jurusanNav.forEach(function(nav) {
            nav.style.display = "block";
        });
        lobbyNav.style.display = "block";
    }
}