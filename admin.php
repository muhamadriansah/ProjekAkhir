<?php
session_start();
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 'admin') {
    header("Location: index.php"); // Arahkan ke halaman login jika bukan admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div>
        <h1>Admin Dashboard</h1>
    </div>
    <div>
        <p><a href="logout.php" style="color: white;">Logout</a></p>
    </div>
</header>

<main>
    <section>
        <h2>Selamat datang, Admin!</h2>
        <p>Anda dapat mengelola foto, komentar, dan fitur lainnya di sini.</p>
    </section>
</main>

</body>
</html>
