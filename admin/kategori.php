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

// Tambah/Edit Kategori
if (isset($_POST['tambahkategori']) || isset($_POST['editkategori'])) {
    global $connect;

    $kategori = mysqli_real_escape_string($connect, $_POST['kategori']);
    $alias = mysqli_real_escape_string($connect, $_POST['alias']);
    $terbit = mysqli_real_escape_string($connect, $_POST['terbit']);

    if (isset($_POST['editkategori'])) {
        $id = (int)$_POST['id'];
        $stmt = $connect->prepare("UPDATE kategori SET Kategori = ?, alias = ?, Terbit = ? WHERE ID = ?");
        if (!$stmt) {
            handle_error("Kesalahan pada query: " . $connect->error);
        } else {
            $stmt->bind_param("sssi", $kategori, $alias, $terbit, $id);
            if ($stmt->execute()) {
                handle_success("Data kategori berhasil diubah.");
                redirect("?mod=kategori&success=edit");
            } else {
                handle_error("Gagal mengubah kategori: " . $stmt->error);
            }
        }
    } else {
        $stmt = $connect->prepare("INSERT INTO kategori (Kategori, alias, Terbit) VALUES (?, ?, ?)");
        if (!$stmt) {
            handle_error("Kesalahan pada query: " . $connect->error);
        } else {
            $stmt->bind_param("sss", $kategori, $alias, $terbit);
            if ($stmt->execute()) {
                handle_success("Data kategori berhasil ditambahkan.");
                redirect("?mod=kategori&success=tambah");
            } else {
                handle_error("Gagal menambahkan kategori: " . $stmt->error);
            }
        }
    }
    $stmt->close();
}

// Ambil data untuk mode edit jika diperlukan
if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $query = mysqli_query($connect, "SELECT * FROM kategori WHERE ID = $id");
    $r = mysqli_fetch_assoc($query);
}

// Hapus Kategori
if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $connect->prepare("DELETE FROM kategori WHERE ID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        handle_success("Kategori berhasil dihapus.");
        redirect("?mod=kategori&success=hapus");
    } else {
        handle_error("Gagal menghapus kategori: " . $stmt->error);
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
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <?php if (!empty($error)): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form action="?mod=kategori" method="POST" class="user-form">
            <fieldset>
                <legend><?= isset($r['ID']) ? 'Edit Kategori' : 'Tambah Kategori' ?></legend>
                
                <?php if (isset($r['ID'])): ?>
                    <input type="hidden" name="id" value="<?= $r['ID'] ?>">
                <?php endif; ?>

                <label for="kategori">Kategori</label>
                <input type="text" id="kategori" name="kategori" placeholder="Kategori" value="<?= isset($r['Kategori']) ? htmlspecialchars($r['Kategori']) : '' ?>" required>

                <label for="alias">Alias</label>
                <input type="text" id="alias" name="alias" placeholder="Alias" value="<?= isset($r['alias']) ? htmlspecialchars($r['alias']) : '' ?>" required>

                <div>
                    <label for="terbit">Terbit</label>
                    <select name="terbit" id="terbit">
                        <option value="1" <?= isset($r['Terbit']) && $r['Terbit'] == 1 ? 'selected' : '' ?>>Yes</option>
                        <option value="0" <?= isset($r['Terbit']) && $r['Terbit'] == 0 ? 'selected' : '' ?>>No</option>
                    </select>
                </div>

                <input type="submit" name="<?= isset($r['ID']) ? 'editkategori' : 'tambahkategori' ?>" value="<?= isset($r['ID']) ? 'Edit' : 'Tambah' ?>">
            </fieldset>
        </form>
    </div>

    <div class="list-container">
        <fieldset>
            <legend>List Kategori</legend>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Alias</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $sql = mysqli_query($connect, "SELECT * FROM kategori ORDER BY ID ASC");
                        while ($row = mysqli_fetch_array($sql)) {
                            echo '
                            <tr>
                                <td data-label="No">' . $i++ . '</td>
                                <td data-label="Kategori">' . htmlspecialchars($row['Kategori']) . '</td>
                                <td data-label="Alias">' . htmlspecialchars($row['alias']) . '</td>
                                <td data-label="Aksi" class="action-buttons">
                                    <a href="?mod=kategori&act=edit&id=' . $row['ID'] . '" class="action-link edit">Edit</a>
                                    <a href="?mod=kategori&act=hapus&id=' . $row['ID'] . '" class="action-link delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus kategori ini?\')">Hapus</a>
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
