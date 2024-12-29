<?php
require_once '../inc/koneksi.php';
require_once '../inc/fungsi.php';

// Mendapatkan data dari database berdasarkan kategori yang dipilih
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

// Query untuk mendapatkan berita sesuai kategori dan yang terbit
$sql = "SELECT * FROM berita WHERE Terbit = 1";
if ($kategori) {
    $sql .= " AND Kategori = '" . mysqli_real_escape_string($connect, $kategori) . "'";
}
$sql .= " ORDER BY Tanggal DESC";

$hasil = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=getprofilweb('site_title')?>-Info</title>
    <link rel="stylesheet" href="../styles/info.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>
<body>
    <div id="navbar-container"></div>
    <header>
        <!-- Carousel Tetap dengan CSS dan JS Kustom -->
        <div class="carousel-container">
            <div class="carousel">
                <div class="carousel-slide no-cover">
                    <img src="../assets/info/Murid Berprestasi.png" alt="Slide 1" />
                    <div class="caption">
                        <p>SMK Hogwarts baru saja memenangkan penghargaan di ajang Olimpiade Sains Nasional. Selamat kepada tim siswa dan pembimbing atas prestasi gemilang ini</p>
                    </div>
                </div>
                <div class="carousel-slide">
                    <img src="../assets/info/kemah.png" alt="Slide 2" />
                    <div class="caption">
                        <h1>Jambore Nasional</h1>
                        <p>Siswa dan Siswi SMK Hogwarts Mengikuti Jambore Nasional</p>
                    </div>
                </div>
                <div class="carousel-slide no-cover">
                    <img src="../assets/info/diskon.png" alt="Slide 3" />
                </div>
            </div>
            <!-- Tombol Navigasi -->
            <a class="prev" onclick="prevSlide()">&#10094;</a>
            <a class="next" onclick="nextSlide()">&#10095;</a>
        </div>

        <div class="menu" id="menu">
        <div class="hamburger"></div>
  </div>

  <!-- Navigation -->
  <ul class="nav buttons-container" id="nav">
    <li><a onclick="filterBerita('Prestasi')">PRESTASI</a></li>
    <li><a onclick="filterBerita('Organisasi')">ORGANISASI</a></li>
    <li><a onclick="filterBerita('Ekstrakurikuler')">EKSTRAKURIKULER</a></li>
    <li><a onclick="filterBerita('Kalender')">KALENDER</a></li>
  </ul>
    </header>

    <main class="container my-4">
        <h2><?php echo htmlspecialchars($kategori); ?></h2>
        <div class="row" id="berita-container">
            <?php
            if (mysqli_num_rows($hasil) > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
                    $gambar = $row['Gambar'] ? '../' . $row['Gambar'] : 'path/to/default-image.jpg';
                    $teks_pendek = substr(strip_tags($row['Teks']), 0, 100) . '...';
                    echo '
                    <div class="col-md-4">
                        <div class="card animate__animated animate__pulse">
                            <img src="' . htmlspecialchars($gambar) . '" alt="Gambar Berita" />
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($row['Judul']) . '</h5>
                                <p class="card-text"><strong>Tanggal:</strong> ' . htmlspecialchars($row['Tanggal']) . '</p>
                                <p class="card-text">' . htmlspecialchars($teks_pendek) . '</p>
                                <a href="detail.php?id=' . $row['ID'] . '" class="btn">Baca selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '
                <div class="text-center">
                    <p>Belum ada berita untuk kategori ini.</p>
                </div>
                ';
            }
            ?>
        </div>
    </main>

    <!-- Link JS Custom -->
    <script src="../script/info.js"></script>
    <script src="../script/main.js" defer></script>
    <script>
        function filterBerita(kategori) {
            window.location.href = "info.php?kategori=" + encodeURIComponent(kategori) + "#berita-container";
        }

        document.addEventListener("DOMContentLoaded", function () {
  const menu = document.getElementById("menu");
  const nav = document.getElementById("nav");

  // Toggle menu
  menu.addEventListener("click", function () {
    menu.classList.toggle("open");
    nav.classList.toggle("visible");
  });
});

    </script>
</body>
</html>