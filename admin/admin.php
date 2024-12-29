<?php
include("ceklogin.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator-<?=getprofilweb('site_title')?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
        $('.summernote').summernote(
            {
        tabsize: 2,
        height: 300,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      }
        );
    });
    </script>
</head>
<body>
    <!-- header -->
    <div class="admin-container">
        <div class="admin-header">
            <h3>Selamat Datang di Halaman Administrator</h3>
            <hr>
        </div>
        <div class="admin-menu">
            <a href="?mod=kategori">Kategori</a>
            <a href="?mod=berita">Berita</a>
            <a href="?mod=konfigurasi">Konfigurasi</a>
            <a href="?mod=testimoni">Testimoni</a>
            <a href="?mod=useradmin">User Admin</a>
            <a href="?keluar=yes">Log Out</a>
        </div>

        <div></div>
        <div id="home">
        <?php
            // Cek apakah key 'mod' ada dalam array $_GET
            $mod = isset($_GET['mod']) ? $_GET['mod'] : null;
    
            switch ($mod) {
              case 'kategori':
                  include("kategori.php");
                  break;
              case 'berita':
                  include("berita.php");
                  break;
              case 'konfigurasi':
                  include("konfigurasi.php");
                  break;
              case 'testimoni':
                  include("testimoni.php");
                  break;
              case 'useradmin':
                  include("useradmin.php");
                  break;
              default:
                  echo "Selamat Datangg " . $_SESSION['loginadminnama'] . " ";
                  break;
            }
        ?>
        </div>
    </div>

    <!-- content -->
</body>
</html>
