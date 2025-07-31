<?php
include "service/database.php";

session_start();

$login_message = "";

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        if (password_verify($password, $data['password'])) {
            $_SESSION["username"] = $data["username"];
            $_SESSION["is_login"] = true;
            $stmt->close();
            header("location: dashboard.php");
            exit();
        } else {
            $login_message = "Password salah, silahkan coba lagi!";
        }
    } else {
        $login_message = "akun tidak ditemukan, silahkan coba lagi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log and Register</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">
</head>

<body>

    <div class="container">

        <div class="form-box login">
            <form action="index.php" method="POST">
                <h1>Login</h1>

                <div class="input-box">
                    <input type="text" placeholder="username" name="username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" placeholder="password" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <i class="login-message"><?= $login_message ?></i>

                <div class="forgot-link">
                    <a href="forgot_password.php">Lupa password?</a>
                </div>
                <button type="submit" class="btn" name="login">Login</button>
                <p>atau login dengan platform sosial</p>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-google'></i></a>
                    <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                    <a href="#"><i class='bx bxl-github'></i></a>
                    <a href="#"><i class='bx bxl-linkedin'></i></a>
                </div>
            </form>
        </div>

        <?php include "register.php" ?>

        <div class="toggle-box">
            <div class="toggle-panel toggle-left">
                <h1>Hallo, selamat datang!</h1>
                <p>Belum punya akun?</p>
                <button class="btn register-btn">Register</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Selamat datang kembali!</h1>
                <p>Sudah punya akun?</p>
                <button class="btn login-btn">Login</button>
            </div>
        </div>

    </div>

    <script src="script.js"></script>
</body>

</html>