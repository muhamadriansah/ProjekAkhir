<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php"; // Koneksi database

// Pastikan parameter 'id' ada di URL
if (!isset($_GET['id'])) {
    echo "ID foto tidak valid.";
    exit();
}

$foto_id = $_GET['id'];

// Ambil data foto berdasarkan FotoID
$query = mysqli_query($con, "SELECT * FROM foto WHERE FotoID = '$foto_id' AND UserID = '{$_SESSION['UserID']}'");
if (mysqli_num_rows($query) > 0) {
    $foto = mysqli_fetch_assoc($query);
} else {
    echo "Foto tidak ditemukan atau Anda tidak memiliki izin untuk mengedit foto ini.";
    exit();
}

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul_foto = mysqli_real_escape_string($con, $_POST['judul']);
    $deskripsi_foto = mysqli_real_escape_string($con, $_POST['deskripsi']);
    $tanggal_unggah = mysqli_real_escape_string($con, $_POST['tanggal']);
    $album_id = $_POST['album'];

    // Jika ada file foto yang di-upload, proses uploadnya
    if ($_FILES['foto']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["foto"]["name"]);
        
        // Cek apakah file berhasil di-upload
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $lokasi_foto = basename($_FILES["foto"]["name"]);
            
            // Hapus foto lama dari folder jika ada file baru yang di-upload
            if (file_exists("uploads/" . $foto['LokasiFoto'])) {
                unlink("uploads/" . $foto['LokasiFoto']);
            }
        } else {
            echo "Terjadi kesalahan saat meng-upload foto.";
            exit();
        }
    } else {
        // Jika tidak ada foto yang di-upload, gunakan foto yang lama
        $lokasi_foto = $foto['LokasiFoto'];
    }

    // Update data foto ke database
    $updateQuery = mysqli_query($con, "UPDATE foto SET 
                                        JudulFoto = '$judul_foto', 
                                        DeskripsiFoto = '$deskripsi_foto', 
                                        TanggalUnggah = '$tanggal_unggah', 
                                        AlbumID = '$album_id', 
                                        LokasiFoto = '$lokasi_foto' 
                                        WHERE FotoID = '$foto_id'");

    if ($updateQuery) {
        // Redirect ke dashboard setelah update berhasil
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui data foto.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Foto</title>
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

        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="date"], textarea, select {
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
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

        img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
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
    <h2>Edit Foto</h2>
    <form action="edit.php?id=<?php echo $foto_id; ?>" method="POST" enctype="multipart/form-data">
        
        <label for="judul">Judul Foto:</label><br>
        <input type="text" id="judul" name="judul" value="<?php echo htmlspecialchars($foto['JudulFoto']); ?>" required><br><br>

        <label for="deskripsi">Deskripsi Foto:</label><br>
        <textarea id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($foto['DeskripsiFoto']); ?></textarea><br><br>

        <label for="tanggal">Tanggal Unggah:</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $foto['TanggalUnggah']; ?>" required><br><br>

        <label for="foto">Foto Sebelumnya:</label><br>
        <!-- Menampilkan foto yang sudah ada -->
        <img src="uploads/<?php echo htmlspecialchars($foto['LokasiFoto']); ?>" width="100" alt="Foto Sebelumnya"><br><br>
        <label for="foto">Upload Foto Baru:</label><br>
        <input type="file" id="foto" name="foto"><br><br>

        <label for="album">Album:</label><br>
        <select name="album" id="album" required>
            <?php
            // Ambil semua album untuk pilihan
            $queryAlbum = "SELECT * FROM album";
            $resultAlbum = mysqli_query($con, $queryAlbum);
            while ($album = mysqli_fetch_assoc($resultAlbum)) {
                $selected = $foto['AlbumID'] == $album['AlbumID'] ? "selected" : "";
                echo "<option value='{$album['AlbumID']}' $selected>{$album['NamaAlbum']}</option>";
            }
            ?>
        </select><br><br>

        <button type="submit">Update Foto</button>
    </form>
</main>

</body>
</html>
