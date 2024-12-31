    <?php
if (!defined('DBHOST')) define("DBHOST", "localhost");
if (!defined('DBUSER')) define("DBUSER", "root");
if (!defined('DBPASS')) define("DBPASS", "amir81443");
if (!defined('DBNAME')) define("DBNAME", "db_webprogramming");
if (!defined('PATH_GAMBAR')) define("PATH_GAMBAR", "../assets/info/berita/");

// if (!defined('URL_SITUS')) define("URL_SITUS", "http://localhost/Project%20UAS/");

$connect = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if (mysqli_connect_error()) {
    echo "Gagal koneksi ke Database: " . mysqli_connect_error();
}
?>
