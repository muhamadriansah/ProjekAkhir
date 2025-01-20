<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        header img {
            width: 50px; /* Ukuran logo */
            height: auto;
            margin-right: 20px;
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
            max-width: 800px;
            margin: auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        p {
            margin: 15px 0;
            text-align: justify;
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
        .account-section a {
            color: #fff;
            text-decoration: none;
            margin-left: 10px;
        }
        .account-section a:hover {
            color: #ff6666;
        }

        /* Style untuk bagian Visi dan Misi */
        .vision-mission {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .vision-mission h3 {
            text-align: center;
            color: #333;
        }

        .vision-mission p {
            text-align: justify;
            font-size: 16px;
            color: #555;
        }

        .vision-mission h4 {
            color: #333;
            margin-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .vision-mission .vision, .vision-mission .mission {
            margin-bottom: 15px;
        }

        .vision-mission ul {
            list-style-type: disc;
            margin-left: 20px;
        }
    </style>
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
    <h2>Selamat Datang di Halaman About</h2>
    <p>
        "CreativeTouch" dapat diartikan sebagai sentuhan kreatif. Nama ini menggambarkan ide atau konsep yang menekankan pada kemampuan untuk menciptakan sesuatu yang unik, berbeda, dan menarik melalui proses kreatif. Cocok untuk sebuah portofolio yang menunjukkan hasil karya desain, seni, atau proyek-proyek inovatif yang memanfaatkan kreativitas untuk memberikan dampak yang kuat.
    </p>
    <p>
        Aplikasi ini dibuat untuk memberikan kemudahan bagi pengguna dalam mengelola dan berbagi foto. 
        Dengan fitur-fitur unggulan seperti unggah foto, membuat album, memberikan komentar, dan memberikan like, 
        kami berharap dapat menciptakan komunitas yang saling terhubung melalui momen-momen yang diabadikan.
    </p>
    <p>
        Tim kami terdiri dari para profesional yang berdedikasi untuk menciptakan pengalaman pengguna yang terbaik. 
        Kami selalu berusaha untuk memperbarui dan meningkatkan fitur-fitur aplikasi ini agar sesuai dengan kebutuhan Anda.
    </p>
    <p>
        Jika Anda memiliki pertanyaan, saran, atau umpan balik, jangan ragu untuk menghubungi kami melalui halaman kontak. 
        Terima kasih telah menjadi bagian dari komunitas kami.
    </p>

    <!-- Visi dan Misi Section -->
    <div class="vision-mission">
        <h3>Visi dan Misi</h3>

        <div class="vision">
            <h4>Visi:</h4>
            <p>Menjadi platform terbaik yang menghubungkan individu melalui foto, memungkinkan berbagi momen yang mempererat hubungan sosial dan menghargai seni visual dalam setiap aspek kehidupan.</p>
        </div>

        <div class="mission">
            <h4>Misi:</h4>
            <ul>
                <li>Memberikan kemudahan dalam mengelola dan berbagi foto dengan fitur-fitur yang inovatif.</li>
                <li>Menciptakan komunitas yang saling terhubung melalui berbagi momen-momen berharga.</li>
                <li>Menjaga kualitas dan keamanan data pengguna dengan standar tinggi.</li>
                <li>Selalu berinovasi dalam pengembangan fitur-fitur untuk memenuhi kebutuhan pengguna.</li>
            </ul>
        </div>
    </div>
</main>
</body>
</html>
