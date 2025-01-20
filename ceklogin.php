<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Username = $_POST['Username'];
    $Password = md5($_POST['Password']);

    // Query ke database untuk memeriksa login
    $query = mysqli_query($con, "SELECT * FROM user WHERE Username='$Username' AND Password='$Password' ");
    $hasilquery = mysqli_num_rows($query);

    if ($hasilquery == 1) {
        session_start();
        $row = mysqli_fetch_assoc($query);
        $_SESSION['Username'] = $row['Username'];
        $_SESSION['UserID'] = $row['UserID'];

        // Redirect ke dashboard
        header("Location: index.php");
        exit(); // Menghentikan eksekusi setelah redirect
    } else {
        echo "Login failed. Username or password is incorrect.";
    }
}
?>