<?php
require_once("../inc/koneksi.php");
date_default_timezone_set('Asia/Jakarta');

// Fungsi untuk menghapus file gambar lama
function hapusGambarLama($path) {
    if (file_exists($path)) {
        unlink($path);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add']) || isset($_POST['update'])) {
        // Input data
        $nama = mysqli_real_escape_string($connect, $_POST['Nama']);
        $isi = mysqli_real_escape_string($connect, $_POST['Isi']);
        $sebagai = mysqli_real_escape_string($connect, $_POST['Sebagai']);
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        $gambar = '';

        // Upload gambar jika ada
        if (!empty($_FILES['gambar']['name']) && ($_FILES['gambar']['error'] === 0)) {
            $filetype = $_FILES['gambar']['type'];
            $allowtype = array('image/jpeg', 'image/jpg', 'image/png');
            $filesize = $_FILES['gambar']['size'];

            if (in_array($filetype, $allowtype) && $filesize <= 2 * 1024 * 1024) { // Maksimal 2 MB
                $path = 'assets/testimoni/';
                $dest = '../' . $path;

                if (!is_dir($dest)) {
                    mkdir($dest, 0755, true);
                }

                $gambarbaru = preg_replace("/[^a-zA-Z0-9]/", "_", $nama);
                $dest1 = $dest . $gambarbaru . '.jpg';
                $gambar = $path . $gambarbaru . '.jpg';

                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $dest1)) {
                    if ($id) {
                        // Hapus gambar lama jika update
                        $sql = mysqli_query($connect, "SELECT Gambar FROM testimoni WHERE ID = $id");
                        $data = mysqli_fetch_assoc($sql);
                        if ($data && $data['Gambar'] !== $gambar) {
                            hapusGambarLama('../' . $data['Gambar']);
                        }
                    }
                } else {
                    echo "Gagal mengupload gambar.";
                    exit;
                }
            } else {
                echo "Jenis file tidak valid atau ukuran file terlalu besar.";
                exit;
            }
        } else {
            // Jika tidak ada gambar baru yang diunggah, gunakan gambar lama
            if ($id) {
                $sql = mysqli_query($connect, "SELECT Gambar FROM testimoni WHERE ID = $id");
                $data = mysqli_fetch_assoc($sql);
                if ($data) {
                    $gambar = $data['Gambar'];
                }
            }
        }

        if (isset($_POST['add'])) {
            // Tambah data
            $stmt = $connect->prepare("INSERT INTO testimoni (Nama, Tanggal, Isi, Sebagai, Gambar) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $nama, date("Y-m-d H:i:s"), $isi, $sebagai, $gambar);
        } elseif (isset($_POST['update'])) {
            // Update data
            $stmt = $connect->prepare("UPDATE testimoni SET Nama = ?, Isi = ?, Sebagai = ?, Gambar = ? WHERE ID = ?");
            $stmt->bind_param("ssssi", $nama, $isi, $sebagai, $gambar, $id);
        }

        if ($stmt->execute()) {
            // Redirect setelah proses berhasil
            header("Location: ?mod=testimoni");
            exit; // Pastikan script berhenti di sini
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Hapus Testimoni
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Pastikan ID berupa integer

    $sql = mysqli_query($connect, "SELECT Gambar FROM testimoni WHERE ID = $id");
    if ($sql && mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        $gambar = $row['Gambar'];
        hapusGambarLama('../' . $gambar);

        $delete = mysqli_query($connect, "DELETE FROM testimoni WHERE ID = $id");
        if ($delete) {
            header("Location: ?mod=testimoni");
            exit;
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } else {
        echo "Data tidak ditemukan.";
    }
}

// Ambil data untuk form edit
if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = mysqli_query($connect, "SELECT * FROM testimoni WHERE ID = $id");
    $data = mysqli_fetch_assoc($query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="?mod=testimoni" method="POST" class="user-form" enctype="multipart/form-data">
            <fieldset>
                <legend><?php echo isset($data) ? 'Edit Testimoni' : 'Tambah Testimoni'; ?></legend>

                <label for="Nama">Nama</label>
                <input type="text" id="Nama" name="Nama" placeholder="Nama" value="<?= isset($data['Nama']) ? htmlspecialchars($data['Nama']) : ''; ?>" size="40" required>

                <div>
                    <label for="sebagai">Sebagai</label>
                    <input type="text" id="sebagai" name="Sebagai" placeholder="Sebagai" value="<?= isset($data['Sebagai']) ? htmlspecialchars($data['Sebagai']) : ''; ?>" required>

                    <label for="gambar">Gambar</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                    <?php if(isset($data['Gambar'])) {?>
                        <img src="../<?= $data['Gambar'] ?>" alt="<?= $data['Nama'] ?>" width="100">
                    <?php } ?>
                </div>

                <label for="isi">Isi</label>
                <textarea id="isi" name="Isi" placeholder="Isi testimoni" cols="80" rows="5" class="summernote" required><?= isset($data['Isi']) ? htmlspecialchars($data['Isi']) : ''; ?></textarea>
                
                
                <input type="hidden" name="id" value="<?php echo isset($data) ? $data['ID'] : ''; ?>">
                <input type="submit" name="<?php echo isset($data) ? 'update' : 'add'; ?>" value="<?php echo isset($data) ? 'Perbarui' : 'Tambah'; ?>">
            </fieldset>
        </form>
    </div>

    <div class="list-container">
        <fieldset>
            <legend>List Testimoni</legend>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Sebagai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    $sql = mysqli_query($connect, "SELECT * FROM testimoni ORDER BY ID ASC");
                    while ($row = mysqli_fetch_array($sql)) {
                        echo '
                        <tr>
                            <td data-label="No">' . $i++ . '</td>
                            <td data-label="Nama">' . htmlspecialchars($row['Nama']) . '</td>
                            <td data-label="Sebagai">' . htmlspecialchars($row['Sebagai']) . '</td>
                            <td data-label="Aksi" class="action-buttons">
                                 <a href="?mod=testimoni&act=edit&id=' . $row['ID'] . '" class="action-link edit">Edit</a>
                                <a href="?mod=testimoni&act=hapus&id=' . $row['ID'] . '" class="action-link delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus berita ini?\')">Hapus</a>
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
