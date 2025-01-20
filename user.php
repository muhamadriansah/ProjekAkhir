<?php
session_start();
if (!isset($_SESSION['Username']) || $_SESSION['Role'] != 'user') {
    header("Location: index.php"); // Arahkan ke halaman login jika bukan user
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <div>
        <h1>User Dashboard</h1>
    </div>
    <div>
        <p><a href="logout.php" style="color: white;">Logout</a></p>
    </div>
</header>

<main>
    <section>
        <h2>Selamat datang, User!</h2>
        <p>Anda dapat melihat foto, memberi like, dan mengomentari foto di sini.</p>
    </section>
</main>

</body>
</html>
