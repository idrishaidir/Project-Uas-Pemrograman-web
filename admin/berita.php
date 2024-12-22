<?php
require_once '../inc/koneksi.php';

if (isset($_POST['add'])) {
    // Menambahkan berita baru
    $gambar = '';
    if (!empty($_FILES['gambar']['name']) && ($_FILES['gambar']['error'] === 0)) {
        $gambarfile_name = $_FILES['gambar']['name'];
        $filetype = $_FILES['gambar']['type'];
        $allowtype = array('image/jpeg', 'image/jpg', 'image/png');

        if (in_array($filetype, $allowtype)) {
            $path = 'assets/info/berita/';
            $dest = '../' . $path;

            if (!is_dir($dest)) {
                mkdir($dest, 0755, true);
            }

            $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $_POST['judul']);
            $dest1 = $dest . $gambarbaru . '.jpg';
            $gambar = $path . $gambarbaru . '.jpg';

            move_uploaded_file($_FILES['gambar']['tmp_name'], $dest1);
        } else {
            echo 'Invalid file type';
            exit;
        }
    }

    $sql = "INSERT INTO berita (Judul, Isi, Kategori, Gambar, Teks, Tanggal, Viewnum, Author, Post_type, Terbit)
    VALUES (
    '" . mysqli_real_escape_string($connect, $_POST['judul']) . "',
    '" . mysqli_real_escape_string($connect, $_POST['isi']) . "',
    '" . mysqli_real_escape_string($connect, $_POST['kategori']) . "',
    '" . mysqli_real_escape_string($connect, $gambar) . "',
    '" . mysqli_real_escape_string($connect, $_POST['teks']) . "',
    '" . date("Y-m-d H:i:s") . "',
    0,
    '" . mysqli_real_escape_string($connect, $_SESSION['loginadmin']) . "',
    'berita',
    '" . intval($_POST['terbit']) . "'
    )";

    $hasil = mysqli_query($connect, $sql);

    if ($hasil) {
        echo "Data berhasil ditambahkan!";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}

// Edit Data Berita
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $judul = mysqli_real_escape_string($connect, $_POST['judul']);
    $isi = mysqli_real_escape_string($connect, $_POST['isi']);
    $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
    $teks = mysqli_real_escape_string($connect, $_POST['teks']);
    $terbit = intval($_POST['terbit']);
    $gambar = '';

    if (!empty($_FILES['gambar']['name']) && ($_FILES['gambar']['error'] === 0)) {
        $gambarfile_name = $_FILES['gambar']['name'];
        $filetype = $_FILES['gambar']['type'];
        $allowtype = array('image/jpeg', 'image/jpg', 'image/png');

        if (in_array($filetype, $allowtype)) {
            $path = 'assets/info/berita/';
            $dest = '../' . $path;

            if (!is_dir($dest)) {
                mkdir($dest, 0755, true);
            }

            $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $judul);
            $dest1 = $dest . $gambarbaru . '.jpg';
            $gambar = $path . $gambarbaru . '.jpg';

            move_uploaded_file($_FILES['gambar']['tmp_name'], $dest1);
        } else {
            echo 'Invalid file type';
            exit;
        }
    }

    $sql = "UPDATE berita SET 
            Judul = '$judul',
            Isi = '$isi',
            Kategori = '$kategori',
            Gambar = '$gambar',
            Teks = '$teks',
            Terbit = '$terbit'
            WHERE ID = '$id'";

    $hasil = mysqli_query($connect, $sql);

    if ($hasil) {
        echo "Data berhasil diperbarui!";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}

// Hapus Berita
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Hapus file gambar jika ada
    $query = mysqli_query($connect, "SELECT Gambar FROM berita WHERE ID = '$id'");
    $row = mysqli_fetch_assoc($query);
    $gambar = $row['Gambar'];

    if ($gambar && file_exists('../' . $gambar)) {
        unlink('../' . $gambar);  // Hapus file gambar
    }

    // Hapus berita
    $sql = "DELETE FROM berita WHERE ID = '$id'";
    $hasil = mysqli_query($connect, $sql);

    if ($hasil) {
        echo "Berita berhasil dihapus!";
    } else {
        echo "Error: " . mysqli_error($connect);
    }
}

// Form Edit Berita
if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($connect, "SELECT * FROM berita WHERE ID = '$id'");
    $data = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="?mod=berita" method="POST" class="user-form" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo isset($data) ? 'Edit Berita' : 'Tambah Berita'; ?></legend>

                <label for="judul">Judul</label>
                <input type="text" id="judul" name="judul" placeholder="Judul Berita" value="<?php echo isset($data) ? htmlspecialchars($data['Judul']) : ''; ?>" size="40" required>

                <div>
                    <label for="kategori">Kategori</label>
                    <select class="select-button" name="kategori" id="kategori" required>
                        <option value="">Pilih Kategori</option>
                        <?php
                        global $connect;
                        $hasil = mysqli_query($connect, "SELECT * FROM kategori WHERE Terbit = '1' ORDER BY ID DESC");

                        if ($hasil) {
                            while ($k = mysqli_fetch_array($hasil)) {
                                echo '<option value="' . htmlspecialchars($k['Kategori']) . '"' . (isset($data) && $data['Kategori'] == $k['Kategori'] ? ' selected' : '') . '>' . htmlspecialchars($k['Kategori']) . '</option>';
                            }
                        } else {
                            echo '<option value="">Gagal memuat kategori</option>';
                        }
                        ?>
                    </select>

                    <label for="isi">Isi Berita</label>
                    <textarea name="isi" id="isi" cols="80" rows="5" class="summernote"><?php echo isset($data) ? htmlspecialchars($data['Isi']) : ''; ?></textarea>

                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar">
                    <?php if (isset($data) && $data['Gambar']) { ?>
                        <br><img src="../<?php echo htmlspecialchars($data['Gambar']); ?>" width="100">
                    <?php } ?>

                    <label for="teks">Teks</label>
                    <textarea name="teks" id="teks" cols="30" rows="5"><?php echo isset($data) ? htmlspecialchars($data['Teks']) : ''; ?></textarea>

                    <div>
                        <label for="terbit">Terbitkan</label>
                        <select name="terbit" id="terbit">
                            <option value="1" <?php echo isset($data) && $data['Terbit'] == 1 ? 'selected' : ''; ?>>Yes</option>
                            <option value="0" <?php echo isset($data) && $data['Terbit'] == 0 ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                </div>

                <input type="hidden" name="id" value="<?php echo isset($data) ? $data['ID'] : ''; ?>">
                <input type="submit" name="<?php echo isset($data) ? 'update' : 'add'; ?>" value="<?php echo isset($data) ? 'Perbarui' : 'Tambah'; ?>">
            </fieldset>
        </form>
    </div>

    <div class="list-container">
    <fieldset>
        <legend>List Berita</legend>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Author</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 1;
                    $sql = mysqli_query($connect, "SELECT berita.ID, berita.Judul, kategori.Kategori, berita.Tanggal, berita.Author FROM berita 
                                                LEFT JOIN kategori ON berita.Kategori = kategori.Kategori ORDER BY berita.ID ASC");
                    while ($row = mysqli_fetch_array($sql)) {
                        echo '
                        <tr>
                            <td data-label="No">' . $i++ . '</td>
                            <td data-label="Judul">' . htmlspecialchars($row['Judul']) . '</td>
                            <td data-label="Kategori">' . htmlspecialchars($row['Kategori']) . '</td>
                            <td data-label="Tanggal">' . htmlspecialchars($row['Tanggal']) . '</td>
                            <td data-label="Author">' . htmlspecialchars($row['Author']) . '</td>
                            <td data-label="Aksi" class="action-buttons">
                                <a href="?mod=berita&act=edit&id=' . $row['ID'] . '" class="action-link edit">Edit</a>
                                <a href="?mod=berita&act=hapus&id=' . $row['ID'] . '" class="action-link delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus berita ini?\')">Hapus</a>
                            </td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </fieldset>
</div>
</body>
</html>
