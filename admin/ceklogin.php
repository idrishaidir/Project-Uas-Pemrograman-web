<?php
include'../inc/fungsi.php';
session_start();
if (isset($_GET['keluar']) && $_GET['keluar'] == 'yes'){
    session_destroy();
    header('Location:admin.php');
}
include("../inc/koneksi.php");

$error = "";

if (isset($_POST['submit'])) {
    global $connect;

    // Ambil data dari form
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password_input = $_POST['password']; // Password yang diinputkan oleh pengguna

    // Query untuk mendapatkan data user berdasarkan username
    $sql = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $stored_password = $user['password']; // Password terenkripsi dari database

        // Verifikasi password
        if (password_verify($password_input, $stored_password)) {
            // Password benar, buat sesi
            $_SESSION['loginadmin'] = $user['username'];
            $_SESSION['loginadminid'] = $user['ID'];
            $_SESSION['loginadminemail'] = $user['email'];
            $_SESSION['loginadminnama'] = $user['Nama'];

            // Redirect ke halaman dashboard atau admin
            header('Location: admin.php');
            exit;
        } else {
            $error = "Password tidak sesuai!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}

// Jika pengguna belum login
if (empty($_SESSION['loginadmin'])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="../styles/login.css">
    <script
      src="https://kit.fontawesome.com/23a7c17145.js"
      crossorigin="anonymous"
    ></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="button-container">
        <button class="home-button">
            <a href="../public/index.html"><i class="fa-solid fa-house"></i>Home</a>
        </button>
    </div>
<div class="login-container">
    <div class="login-card">
        <h1>Welcome Back!</h1>
        <p>Please login to your account</p>
        <form action="admin.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <input type="submit" name="submit" value="Login" class="btn-login">
            <?php if (!empty($error)) { ?>
                <p style="color:red; margin-top:10px;"><?php echo $error; ?></p>
            <?php } ?>
        </form>
    </div>
</div>
</body>
</html>
<?php
    exit;
}
?>
