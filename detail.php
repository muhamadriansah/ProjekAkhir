<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php"; // Koneksi database

// Mendapatkan ID foto yang dipilih dari URL
if (isset($_GET['id'])) {
    $fotoID = $_GET['id'];

    // Query untuk mendapatkan detail foto berdasarkan FotoID
    $query = "SELECT foto.FotoID, foto.JudulFoto, foto.DeskripsiFoto, foto.TanggalUnggah, foto.LokasiFoto, 
                     album.NamaAlbum, user.Username 
              FROM foto 
              INNER JOIN album ON foto.AlbumID = album.AlbumID 
              INNER JOIN user ON foto.UserID = user.UserID
              WHERE foto.FotoID = $fotoID";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $judulFoto = $row['JudulFoto'];
        $deskripsiFoto = $row['DeskripsiFoto'];
        $tanggalUnggah = $row['TanggalUnggah'];
        $lokasiFoto = $row['LokasiFoto'];
        $namaAlbum = $row['NamaAlbum'];
        $username = $row['Username'];
    } else {
        echo "Foto tidak ditemukan.";
        exit();
    }
} else {
    echo "ID Foto tidak valid.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Foto</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        header {
            background: #333;
            color: #fff;
            padding: 10px 20px;
            text-align: center;
        }
        main {
            padding: 20px;
            max-width: 900px;
            margin: auto;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .photo-detail {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .photo-detail img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .photo-detail h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .photo-detail p {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
        }
        .photo-detail .info {
            font-size: 16px;
            color: #777;
        }
        .photo-detail .info p {
            margin: 5px 0;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<header>
    <h1>CreativeTouch - Detail Foto</h1>
</header>

<main>
    <section class="photo-detail">
        <img src="uploads/<?php echo htmlspecialchars($lokasiFoto); ?>" alt="<?php echo htmlspecialchars($judulFoto); ?>">
        <h2><?php echo htmlspecialchars($judulFoto); ?></h2>
        <p><?php echo nl2br(htmlspecialchars($deskripsiFoto)); ?></p>

        <div class="info">
            <p><strong>Album:</strong> <?php echo htmlspecialchars($namaAlbum); ?></p>
            <p><strong>Diupload oleh:</strong> <?php echo htmlspecialchars($username); ?></p>
            <p><strong>Tanggal Unggah:</strong> <?php echo htmlspecialchars($tanggalUnggah); ?></p>
        </div>

        <a href="index.php" class="back-button">Kembali</a>
    </section>
</main>

</body>
</html>
