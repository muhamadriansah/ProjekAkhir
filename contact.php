<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Check if there is a 'success' parameter in the URL (passed from send_message.php)
$success = isset($_GET['success']) ? $_GET['success'] : false;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        nav {
            background-color: #444;
            color: white;
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
            max-width: 1200px;
            margin: auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        section {
            margin-bottom: 30px;
        }
        form label, form input, form textarea, form select, form button {
            display: block;
            width: 100%;
            margin-bottom: 15px;
        }
        form input, form textarea, form select {
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        form button:hover {
            background-color: #555;
        }

        .account-section {
            display: flex;
            align-items: center;
        }

        .account-section img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .account-section p {
            margin: 0;
        }

        .account-section a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
        }

        .account-section a:hover {
            color: #ff6666;
        }
    </style>
    <script>
        // JavaScript to show the popup after form submission
        window.onload = function() {
            <?php if ($success) { ?>
                alert("Pesan Anda telah terkirim!");
            <?php } ?>
        };
    </script>
</head>
<body>
<header>
    <div style="display: flex; align-items: center;">
        <img src="uploads/creativetouch.png" alt="CreativeTouch Logo" style="width: 50px; height: auto; margin-right: 10px;">
        <h1 style="margin: 0;">CreativeTouch</h1>
    </div>
    <div class="account-section">
        <img src="uploads/icon org.png" alt="User Icon" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 10px;">
        <a href="akun.php" style="color: #fff;">
            <?php echo htmlspecialchars($_SESSION['Username']); ?>
        </a>
        <a href="logout.php" style="color: #ff6666; margin-left: 10px;">Logout</a>
    </div>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="gallery.php">Gallery</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <a href="upload.php">Upload Foto</a>
</nav>

<main>
    <section>
        <h2>Hubungi Kami</h2>
        <form action="send_message.php" method="POST">
            <label for="name">Nama Lengkap</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="subject">Subjek</label>
            <input type="text" id="subject" name="subject" required>

            <label for="message">Pesan</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Kirim Pesan</button>
        </form>
    </section>
</main>
</body>
</html>
