<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

include "koneksi.php"; // Koneksi database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $tanggal = $_POST['tanggal'];
    $album = $_POST['album'];

    // Handle file upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileName = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];

        // Check file type and size
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB max size
        if (in_array($fileType, $allowedTypes) && $fileSize <= $maxFileSize) {
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . basename($fileName);

            if (move_uploaded_file($fileTmpPath, $filePath)) {
                // Insert photo data into database
                $userID = $_SESSION['UserID'];
                $query = "INSERT INTO foto (JudulFoto, DeskripsiFoto, TanggalUnggah, LokasiFoto, AlbumID, UserID) 
                          VALUES ('$judul', '$deskripsi', '$tanggal', '$filePath', '$album', '$userID')";
                if (mysqli_query($con, $query)) {
                    header("Location: index.php"); // Redirect back to dashboard after upload
                    exit();
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type or file size exceeded.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Foto</title>
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
    </style>
</head>
<body>
    <header>
        <h1>Unggah Foto Baru</h1>
        <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['Username']); ?> | <a href="logout.php" style="color: #ff6666;">Logout</a></p>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="gallery.php">Gallery</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="upload.php">Upload Foto</a>
    </nav>

    <main>
        <h2>Unggah Foto</h2>
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <label for="judul">Judul Foto:</label>
            <input type="text" id="judul" name="judul" placeholder="Masukkan judul foto" required>

            <label for="deskripsi">Deskripsi Foto:</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi foto" required></textarea>

            <label for="tanggal">Tanggal Unggah:</label>
            <input type="date" id="tanggal" name="tanggal" required>

            <label for="foto">Upload Foto:</label>
            <input type="file" id="foto" name="foto" required>

            <label for="album">Album:</label>
            <select name="album" id="album" required>
                <?php
                $query = "SELECT * FROM album";
                $result = mysqli_query($con, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='{$row['AlbumID']}'>{$row['NamaAlbum']}</option>";
                }
                ?>
            </select>

            <button type="submit">Unggah</button>
        </form>
    </main>
</body>
</html>
