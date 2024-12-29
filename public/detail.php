<?php
require_once '../inc/koneksi.php';
require_once '../inc/fungsi.php';

// Mendapatkan ID berita dari parameter URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validasi ID dan query untuk mendapatkan detail berita
$sql = "SELECT * FROM berita WHERE ID = '" . mysqli_real_escape_string($connect, $id) . "'";
$hasil = mysqli_query($connect, $sql);
$berita = mysqli_fetch_assoc($hasil);

// Jika berita tidak ditemukan
if (!$berita) {
    echo "<h1>Berita tidak ditemukan</h1>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=getprofilweb('detail-info')?></title>
    <!-- Link CSS Custom -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/id_ID/sdk.js#xfbml=1&version=v21.0"></script>
    <link rel="stylesheet" href="../styles/detail.css" />
</head>
<body>
    <div id="navbar-container"></div>
    <main class="container">
        <div class="berita-detail">
            <h2 class="judul-berita">
                <?php echo htmlspecialchars($berita['Judul']); ?>
            </h2>
            <p class="tanggal-berita">
                <strong>Tanggal:</strong> <?php echo htmlspecialchars($berita['Tanggal']); ?>
            </p>
            <img 
                src="<?php echo !empty($berita['Gambar']) ? '../' . htmlspecialchars($berita['Gambar']) : '../assets/default-image.jpg'; ?>" 
                alt="Gambar Berita" 
                class="gambar-berita"
            />
            <div class="isi-berita">
            <?php 
            echo strip_tags($berita['Isi'], '<b><i><strong><a><p><br>');
            ?>

            </div>
            <div id="fb-root"></div>
            <?php
                // Ganti URL lokal dengan URL yang diinginkan
                $uri = 'http://yourdomain.com' . $_SERVER['REQUEST_URI'];
            ?>

            <div class="fb-comments" data-href="<?php echo $uri; ?>" data-width="500" data-numposts="5"></div>
            <a href="info.php" class="btn-back">&larr; Kembali ke Daftar Berita</a>
        </div>
    </main>

    <!-- Link JS Custom -->
    <script src="../script/main.js" defer></script>
</body>
</html>
