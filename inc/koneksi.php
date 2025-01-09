<?php
if (!defined('DBHOST')) define("DBHOST", "localhost");
if (!defined('DBUSER')) define("DBUSER", "root");
if (!defined('DBPASS')) define("DBPASS", "");
if (!defined('DBNAME')) define("DBNAME", "db_websekolah");
if (!defined('PATH_GAMBAR')) define("PATH_GAMBAR", "../assets/info/berita/");

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if (mysqli_connect_error()) {
    echo "Gagal koneksi ke Database: " . mysqli_connect_error();
}
?>
