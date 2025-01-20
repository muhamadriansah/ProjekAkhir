<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

include "koneksi.php"; // Koneksi database

// Pastikan parameter 'id' ada dan valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $foto_id = $_GET['id'];

    // Sanitasi input untuk menghindari SQL Injection
    $foto_id = mysqli_real_escape_string($con, $foto_id);

    // Cek apakah foto dengan ID tersebut ada
    $query = mysqli_query($con, "SELECT * FROM foto WHERE FotoID = '$foto_id'");
    if (mysqli_num_rows($query) > 0) {
        $foto = mysqli_fetch_assoc($query);
        $lokasi_foto = $foto['LokasiFoto'];
        $user_id = $foto['UserID']; // Pastikan foto milik pengguna yang login

        // Periksa apakah foto ini milik pengguna yang login
        if ($user_id == $_SESSION['UserID']) {
            // Hapus foto dari folder uploads
            if (file_exists("uploads/" . $lokasi_foto)) {
                unlink("uploads/" . $lokasi_foto);
            }

            // Hapus data foto dari database
            $deleteQuery = mysqli_query($con, "DELETE FROM foto WHERE FotoID = '$foto_id'");

            if ($deleteQuery) {
                // Redirect ke halaman dashboard setelah penghapusan sukses
                header("Location: index.php");
                exit();
            } else {
                echo "Terjadi kesalahan saat menghapus data foto.";
            }
        } else {
            echo "Anda tidak memiliki izin untuk menghapus foto ini.";
        }
    } else {
        echo "Foto tidak ditemukan.";
    }
} else {
    echo "ID foto tidak valid.";
}
?>
