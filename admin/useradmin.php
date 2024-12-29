<?php
// include("ceklogin.php");
function handle_error($message) {
    global $error;
    $error = $message;
}

function handle_success($message) {
    global $success;
    $success = $message;
}

// Tambah User
if (isset($_POST['tambahuser'])) {
    global $connect;

    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];
    $nama = mysqli_real_escape_string($connect, $_POST['nama']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    $stmt = $connect->prepare("SELECT * FROM admin WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        handle_error("Username atau email sudah digunakan.");
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare("INSERT INTO admin (Nama, username, password, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nama, $username, $hashedPassword, $email);
        if ($stmt->execute()) {
            handle_success("User berhasil ditambahkan!");
        } else {
            handle_error("Terjadi kesalahan saat menambahkan user.");
        }
    }
}

// Edit User
if (isset($_GET['act']) && $_GET['act'] == 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $connect->prepare("SELECT * FROM admin WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $r = $result->fetch_assoc() ?? handle_error("User tidak ditemukan.");
}

// Update User
if (isset($_POST['edituser'])) {
    global $connect;

    $id = (int)$_POST['userid'];
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = $_POST['password'];
    $nama = mysqli_real_escape_string($connect, $_POST['nama']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);

    $stmt = $connect->prepare("SELECT * FROM admin WHERE (username = ? OR email = ?) AND ID != ?");
    $stmt->bind_param("ssi", $username, $email, $id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        handle_error("Username atau email sudah digunakan.");
    } else {
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $stmt = $connect->prepare("SELECT password FROM admin WHERE ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $hashedPassword = $stmt->get_result()->fetch_assoc()['password'];
        }

        $stmt = $connect->prepare("UPDATE admin SET Nama = ?, username = ?, password = ?, email = ? WHERE ID = ?");
        $stmt->bind_param("ssssi", $nama, $username, $hashedPassword, $email, $id);
        if ($stmt->execute()) {
            handle_success("User berhasil diupdate!");
        } else {
            handle_error("Terjadi kesalahan saat mengupdate user.");
        }
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'hapus' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = mysqli_query($connect,"DELETE FROM admin WHERE ID='$id'");
    handle_success("User berhasil dihapus");
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
            <div class="alert error"><?php echo $error; ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="alert success"><?php echo $success; ?></div>
        <?php endif; ?>

        <form action="?mod=useradmin" method="POST" class="user-form">
                <input type="hidden" name="userid" value="<?= isset($r['ID']) ? $r['ID'] : '' ?>">
            <fieldset>
                <legend><?= isset($r['ID']) ? 'Edit User' : 'Tambah User' ?></legend>

                <label for="nama">Nama User</label>
                <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" value="<?= isset($r['Nama']) ? htmlspecialchars($r['Nama']) : '' ?>" required>

                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" value="<?= isset($r['username']) ? htmlspecialchars($r['username']) : '' ?>" required>

                <label for="password">Password</label>
                <input type="text" id="password" name="password" placeholder="Password" value="<?= isset($r['password']) ? str_repeat('*', 8) : '' ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Email Address" value="<?= isset($r['email']) ? htmlspecialchars($r['email']) : '' ?>" required>

                <input type="submit" name="<?= isset($r['ID']) ? 'edituser' : 'tambahuser' ?>" value="<?= isset($r['ID']) ? 'Edit' : 'Tambah' ?>">
            </fieldset>
        </form>
        <fieldset>
            <legend>List User</legend>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $i = 1;
                        $sql = mysqli_query($connect, "SELECT * FROM admin ORDER BY ID ASC");
                        while ($r = mysqli_fetch_array($sql)) {
                            echo '
                            <tr>
                                <td data-label="No">' . $i++ . '</td>
                                <td data-label="Username">' . htmlspecialchars($r['username']) . '</td>
                                <td data-label="Nama">' . htmlspecialchars($r['Nama']) . '</td>
                                <td data-label="Email">' . htmlspecialchars($r['email']) . '</td>
                                <td data-label="Aksi" class="action-buttons">
                                    <a href="?mod=useradmin&act=edit&id=' . $r['ID'] . '" class="action-link edit">Edit</a>
                                    <a href="?mod=useradmin&act=hapus&id=' . $r['ID'] . '" class="action-link delete" onclick="return confirm(\'Apakah Anda yakin ingin menghapus user ini?\')">Hapus</a>
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
