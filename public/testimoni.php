<?php
require_once '../inc/koneksi.php';
require_once '../inc/fungsi.php';

// Mendapatkan data dari database
$sql = "SELECT * FROM testimoni ORDER BY Tanggal DESC";
$hasil = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni</title>
    <link rel="stylesheet" href="../styles/testimoni.css">
</head>
<body>
    <div id="navbar-container"></div>
    <header>
        <h1>Testimoni</h1>
    </header>

    <main class="container my-4">
        <div class="row" id="testimoni-container">
            <?php
            if (mysqli_num_rows($hasil) > 0) {
                while ($row = mysqli_fetch_assoc($hasil)) {
                    $gambar = $row['Gambar'] ? '../' . $row['Gambar'] : 'path/to/default-image.jpg';
                    echo '
                    <div class="col-md-4">
                        <div class="card">
                            <img src="' . $gambar . '" alt="Gambar Testimoni" />
                            <div class="card-body">
                            <h5 class="card-title">' . htmlspecialchars($row['Nama']) . '</h5>
                            <p class="tanggal">' . htmlspecialchars($row['Tanggal']) . '</p>
                            <p class="card-text"><strong>Sebagai:</strong> ' . htmlspecialchars($row['Sebagai']) . '</p>
                             <p class="card-text">"' . htmlspecialchars(strip_tags($row['Isi'])) . '"</p>
                            </div>
                        </div>
                    </div>
                    ';
                }
            } else {
                echo '
                <div class="text-center">
                    <p>Belum ada testimoni.</p>
                </div>
                ';
            }
            ?>
        </div>
    </main>
    <script src="../script/testimoni.js"></script>
    <script src="../script/main.js" defer></script>
</body>
</html>
