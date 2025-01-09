<?php
function handle_error($message) {
    global $error;
    $error = $message;
}

function handle_success($message) {
    global $success;
    $success = $message;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

// Tambah/Edit Konfigurasi
if (isset($_POST['tambahkonfigurasi']) || isset($_POST['editkonfigurasi'])) {
    global $connect;

    $nama = mysqli_real_escape_string($connect, $_POST['nama']);
    $tax = mysqli_real_escape_string($connect, $_POST['tax']);
    $isi = mysqli_real_escape_string($connect, $_POST['isi']);
    $link = mysqli_real_escape_string($connect, $_POST['link']);
    $tipe = "konfigurasi";

    if (isset($_POST['editkonfigurasi'])) {
        $id = (int)$_POST['id'];
        $stmt = $connect->prepare("UPDATE konfigurasi SET Nama = ?, Tax = ?, Isi = ?, Link = ? WHERE ID = ?");
        if (!$stmt) {
            handle_error("Kesalahan pada query: " . $connect->error);
        } else {
            $stmt->bind_param("ssssi", $nama, $tax, $isi, $link, $id);
            if ($stmt->execute()) {
                handle_success("Data konfigurasi berhasil diubah.");
                redirect("?mod=konfigurasi&success=edit");
            } else {
                handle_error("Gagal mengubah konfigurasi: " . $stmt->error);
            }
        }
    } else {
        $stmt = $connect->prepare("INSERT INTO konfigurasi (Nama, Tax, Isi, Link, Tipe) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            handle_error("Kesalahan pada query: " . $connect->error);
        } else {
            $stmt->bind_param("sssss", $nama, $tax, $isi, $link, $tipe);
            if ($stmt->execute()) {
                handle_success("Data konfigurasi berhasil ditambahkan.");
                redirect("?mod=konfigurasi&success=tambah");
            } else {
                handle_error("Gagal menambahkan konfigurasi: " . $stmt->error);
            }
        }
    }
    $stmt->close();
}

// Ambil data untuk mode edit jika diperlukan
if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = mysqli_query($connect, "SELECT * FROM konfigurasi WHERE ID = $id");
    $r = mysqli_fetch_assoc($query);
}

// Hapus Konfigurasi
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $connect->prepare("DELETE FROM konfigurasi WHERE ID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        handle_success("Konfigurasi berhasil dihapus.");
        redirect("?mod=konfigurasi&success=hapus");
    } else {
        handle_error("Gagal menghapus konfigurasi: " . $stmt->error);
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="user-form">
            <fieldset>
                <legend><?= isset($r['ID']) ? 'Edit Konfigurasi' : 'Tambah Konfigurasi' ?></legend>
                
                <?php if (isset($r['ID'])): ?>
                    <input type="hidden" name="id" value="<?= $r['ID'] ?>">
                <?php endif; ?>

                <label for="nama">Nama</label>
                <input type="text" id="nama" name="nama" placeholder="Nama" value="<?= isset($r['Nama']) ? htmlspecialchars($r['Nama']) : '' ?>" required>

                <label for="tax">TAX</label>
                <input type="text" id="tax" name="tax" placeholder="TAX" value="<?= isset($r['Tax']) ? htmlspecialchars($r['Tax']) : '' ?>" required>

                <label for="isi">Isi</label>
                <input type="text" id="isi" name="isi" placeholder="Isi" value="<?= isset($r['Isi']) ? htmlspecialchars($r['Isi']) : '' ?>" required>

                <label for="link">Link</label>
                <input type="text" id="link" name="link" placeholder="Link" value="<?= isset($r['Link']) ? htmlspecialchars($r['Link']) : '' ?>" required>

                <input type="submit" name="<?= isset($r['ID']) ? 'editkonfigurasi' : 'tambahkonfigurasi' ?>" value="<?= isset($r['ID']) ? 'Edit' : 'Tambah' ?>">
            </fieldset>
        </form>
    </div>

    <div class="list-container">
        <fieldset>
            <legend>List Konfigurasi</legend>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tax</th>
                        <th>Isi</th>
                        <th>Link</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $sql = mysqli_query($connect, "SELECT * FROM konfigurasi ORDER BY ID ASC");
                        while ($row = mysqli_fetch_array($sql)) {
                            echo '
                            <tr>
                                <td data-label="No">' . $i++ . '</td>
                                <td data-label="Nama">' . htmlspecialchars($row['Nama']) . '</td>
                                <td data-label="Tax">' . htmlspecialchars($row['Tax']) . '</td>
                                <td data-label="Isi">' . htmlspecialchars($row['Isi']) . '</td>
                                <td data-label="Link">' . htmlspecialchars($row['Link']) . '</td>
                                <td data-label="Aksi" class="action-buttons">
                                    <a href="?mod=konfigurasi&act=edit&id=' . $row['ID'] . '" class="action-link edit">Edit</a>
                                    <a href="?mod=konfigurasi&act=hapus&id=' . $row['ID'] . '" class="action-link delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus konfigurasi ini?\')">Hapus</a>
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
