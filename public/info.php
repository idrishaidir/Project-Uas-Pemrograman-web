<?php
  require_once '../inc/koneksi.php';

  // Mendapatkan data dari database berdasarkan kategori yang dipilih
  $kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

  // Query untuk mendapatkan berita sesuai kategori
  $sql = "SELECT * FROM berita";
  if ($kategori) {
      $sql .= " WHERE Kategori = '" . mysqli_real_escape_string($connect, $kategori) . "'";
  }
  $sql .= " ORDER BY Tanggal DESC";

  $hasil = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Info SMA Hogwarts</title>
    <!-- Link CSS Custom -->
    <link rel="stylesheet" href="../styles/info.css" />
  </head>
  <body>
    <div id="navbar-container"></div>
    <header>
      <!-- Carousel Tetap dengan CSS dan JS Kustom -->
      <div class="carousel-container">
        <div class="carousel">
          <div class="carousel-slide">
            <img src="../assets/info/Murid Berprestasi.png" alt="Slide 1" />
            <div class="caption">
              <h1>Welcome To<br />SMA HOGWARTS</h1>
              <p>Menyihir Dunia dengan Prestasi</p>
            </div>
          </div>
          <div class="carousel-slide">
            <img src="../assets/info/kemah.png" alt="Slide 2" />
          </div>
          <div class="carousel-slide">
            <img src="../assets/info/diskon.png" alt="Slide 3" />
            <div class="caption">
              <h1>Program Lulus 2 Tahun</h1>
              <p>Untuk Kamu yang siap berprestasi lebih cepat!</p>
            </div>
          </div>
        </div>
        <!-- Tombol Navigasi -->
        <button class="prev" onclick="prevSlide()">&#10094;</button>
        <button class="next" onclick="nextSlide()">&#10095;</button>
      </div>

      <!-- Filter Buttons -->
      <div class="buttons-container">
        <a
          id="scrollButton"
          onclick="filterBerita('Prestasi')"
          ><button>PRESTASI</button></a
        >
        <a href="#" onclick="filterBerita('Organisasi')"
          ><button>ORGANISASI</button></a
        >
        <a href="#" onclick="filterBerita('Ekstrakurikuler')"
          ><button>EKSTRAKURIKULER</button></a
        >
        <a href="#" onclick="filterBerita('Kalender')"
          ><button>KALENDER</button></a
        >
        <a href="#" onclick="filterBerita('')"><button>Terkini</button></a>
      </div>
    </header>

    <main class="container my-4">
      <h2>
        <?php echo $kategori ? '' . htmlspecialchars($kategori) : 'Berita Terbaru'; ?>
      </h2>
      <div class="row">
        <?php
            if (mysqli_num_rows($hasil) >
        0) { while ($row = mysqli_fetch_assoc($hasil)) { $gambar =
        $row['Gambar'] ? '../' . $row['Gambar'] : 'path/to/default-image.jpg';
        $teks_pendek = substr(strip_tags($row['Teks']), 0, 100) . '...'; echo '
        <div class="col-md-4">
          <div class="card">
            <img src="' . $gambar . '" alt="Gambar Berita" />
            <div class="card-body">
              <h5 class="card-title">
                ' . htmlspecialchars($row['Judul']) . '
              </h5>
              <p class="card-text">
                <strong>Tanggal:</strong> ' . htmlspecialchars($row['Tanggal'])
                . '
              </p>
              <p class="card-text">' . htmlspecialchars($teks_pendek) . '</p>
              <a href="detail.php?id=' . $row['ID'] . '" class="btn"
                >Baca selengkapnya</a
              >
            </div>
          </div>
        </div>
        '; } } else { echo '
        <div class="text-center">
          <p>Belum ada berita untuk kategori ini.</p>
        </div>
        '; } ?>
      </div>
    </main>

    <!-- Link JS Custom -->
    <script src="../script/info.js"></script>
    <script src="../script/main.js" defer></script>
    <script>
      // Fungsi untuk memfilter berita
      function filterBerita(kategori) {
        // Redirect ke halaman dengan parameter kategori
        window.location.href =
          "info.php?kategori=" + encodeURIComponent(kategori);
      }
    </script>
  </body>
</html>
