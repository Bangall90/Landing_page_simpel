<?php
include "service/database.php";

$register_message = "";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Gunakan prepared statement untuk keamanan
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            $register_message = "daftar akun berhasil, silahkan login";
        } else {
            $register_message = "daftar akun gagal, silahkan coba lagi";
        }
        $stmt->close();
    } catch (mysqli_sql_exception) {
        $register_message = "username sudah digunkan, silahkan ganti";
    }
    $db->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="shortcut icon" href="assets/img/icon.png" type="image/x-icon">

    <title>register</title>
</head>

<body>
    <i><?= $register_message ?> </i>
    <div class="form-box register">
        <form action="register.php" method="POST">
            <h1>Registration</h1>
            <div class="input-box">
                <input type="text" placeholder="username" name="username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="password" name="password" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="btn" name="register">Register</button>
            <p>atau register dengan platform sosial</p>
            <div class="social-icons">
                <a href="#"><i class='bx bxl-google'></i></a>
                <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                <a href="#"><i class='bx bxl-github'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>
        </form>
    </div>
</body>

</html>