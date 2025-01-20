<?php
session_start();
include "koneksi.php"; // Koneksi database
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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

        .welcome-message {
            text-align: center;
            background-color: rgb(60, 61, 60);
            color: white;
            padding: 40px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .photo-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }

        .photo-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .card-body {
            padding: 15px;
        }
    </style>
</head>
<body>
<header>
    <div style="display: flex; align-items: center;">
        <img src="uploads/creativetouch.png" alt="CreativeTouch Logo" style="width: 50px; height: auto; margin-right: 10px;">
        <h1 style="margin: 0;">CreativeTouch</h1>
    </div>

    <div class="login-logout">
        <?php if (!isset($_SESSION['Username'])): ?>
            <a href="login.php">Login</a>
        <?php else: ?>
            <span style="color: #fff;">Halo, <?php echo htmlspecialchars($_SESSION['Username']); ?></span>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="gallery.php">Gallery</a>
    <a href="about.php">About</a>
    <a href="contact.php">Contact</a>
    <a href="upload.php">Upload Foto</a> <!-- Link ke halaman upload -->
</nav>

<main>
    <section class="welcome-message">
        <h2>Selamat datang!</h2>
        <p>Terima kasih telah mengunjungi CreativeTouch. Kami berharap Anda menikmati setiap fitur yang tersedia!</p>
    </section>

    <section>
    <h2>Foto yang Telah Diupload</h2>
    <div class="photo-grid">
        <?php
        $query = "SELECT foto.FotoID, foto.JudulFoto, foto.DeskripsiFoto, foto.TanggalUnggah, foto.LokasiFoto, 
                         album.NamaAlbum, user.Username, foto.UserID AS FotoUserID
                  FROM foto 
                  INNER JOIN album ON foto.AlbumID = album.AlbumID 
                  INNER JOIN user ON foto.UserID = user.UserID";
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            $likeQuery = "SELECT COUNT(*) AS like_count FROM likefoto WHERE FotoID = {$row['FotoID']}";
            $likeResult = mysqli_query($con, $likeQuery);
            $likeData = mysqli_fetch_assoc($likeResult);
            $likeCount = $likeData['like_count'];

            $commentQuery = "SELECT COUNT(*) AS comment_count FROM komentarfoto WHERE FotoID = {$row['FotoID']}";
            $commentResult = mysqli_query($con, $commentQuery);
            $commentData = mysqli_fetch_assoc($commentResult);
            $commentCount = $commentData['comment_count'];

            echo "<div class='photo-card'>
                    <img src='uploads/{$row['LokasiFoto']}' alt='{$row['JudulFoto']}'>
                    <div class='card-body'>
                        <h3>{$row['JudulFoto']}</h3>
                        <p><strong>Like:</strong> {$likeCount}</p>
                        <p><strong>Komentar:</strong> {$commentCount}</p>";

            echo "<a href='detail.php?id={$row['FotoID']}' class='action-btns'>
                    <i class='fas fa-info-circle'></i> Selengkapnya
                  </a>";

            // Menambahkan tombol hapus jika foto milik pengguna yang login
            if (isset($_SESSION['UserID']) && $_SESSION['UserID'] == $row['FotoUserID']) {
                echo "<a href='delete.php?id={$row['FotoID']}' class='action-btns' onclick='return confirm(\"Apakah Anda yakin ingin menghapus foto ini?\");'>
                        <i class='fas fa-trash-alt'></i> Hapus
                      </a>";
            }

            echo "</div></div>";
        }
        ?>
    </div>
</section>

</main>
</body>
</html>
