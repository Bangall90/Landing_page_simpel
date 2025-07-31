<?php
include "service/database.php";

$reset_message = "";
$show_reset_form = false;
$username = "";

if (isset($_POST['find_user'])) {
    $username = $_POST['username'];
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $show_reset_form = true;
    } else {
        $reset_message = "Username tidak ditemukan.";
    }
}

if (isset($_POST['reset_password'])) {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $stmt = $db->prepare("UPDATE users SET password=? WHERE username=?");
    $stmt->bind_param("ss", $hashed, $username);
    if ($stmt->execute()) {
        $reset_message = "Password berhasil direset. Silakan login.";
        $show_reset_form = false;
    } else {
        $reset_message = "Gagal reset password.";
        $show_reset_form = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link rel="stylesheet" href="assets/css/forgot_password.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
</head>
<body>
    <div class="reset-container">
        <?php if ($show_reset_form): ?>
            <form action="" method="POST">
                <h2>Reset Password</h2>
                <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                <input type="password" name="new_password" placeholder="Password baru" required>
                <button type="submit" name="reset_password">Reset Password</button>
                <p><?= $reset_message ?></p>
                <a href="index.php">Kembali ke Login</a>
            </form>
        <?php else: ?>
            <form action="" method="POST">
                <h2>Lupa Password</h2>
                <input type="text" name="username" placeholder="Masukkan username Anda" required>
                <button type="submit" name="find_user">Cari Akun</button>
                <p><?= $reset_message ?></p>
                <a href="index.php">Kembali ke Login</a>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
