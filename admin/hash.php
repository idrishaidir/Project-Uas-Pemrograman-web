<?php
// Password yang ingin Anda simpan
$password = 'a';

// Meng-hash password menggunakan password_hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Menampilkan hash password yang telah terenkripsi
echo "Hashed Password: " . $hashed_password;
?>
