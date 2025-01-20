<?php
session_start();
include 'koneksi.php';

// Proses registrasi jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NamaLengkap = $_POST['NamaLengkap'];
    $Username = $_POST['Username'];
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];
    $Alamat = $_POST['Alamat'];
    $Role = $_POST['Role']; // Menangkap role yang dipilih

    // Hash password sebelum disimpan
    $hashed_password = md5($Password);

    // Cek apakah username atau email sudah terdaftar
    $check_query = "SELECT * FROM user WHERE Username = ? OR Email = ?";
    $stmt = $con->prepare($check_query);
    $stmt->bind_param("ss", $Username, $Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username atau email sudah terdaftar!";
    } else {
        // Insert data pengguna baru ke tabel users
        $query = "INSERT INTO user (NamaLengkap, Username, Email, Password, Alamat, Role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_insert = $con->prepare($query);
        $stmt_insert->bind_param("ssssss", $NamaLengkap, $Username, $Email, $hashed_password, $Alamat, $Role);

        if ($stmt_insert->execute()) {
            // Set session login untuk pengguna baru
            $_SESSION['Username'] = $Username;
            header("Location: login.php?success=Registrasi berhasil. Selamat datang, $Username!");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat registrasi, silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling untuk form dan layout */
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
            max-width: 800px;
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
</head>
<body>

<header>
    <div>
        <h1>Register</h1>
    </div>
</header>

<main>
    <section>
        <?php
        if (isset($error_message)) {
            echo "<p style='color:red;'>$error_message</p>";
        }
        ?>

        <form action="register.php" method="POST">
            <h2>Register</h2>
            <label for="NamaLengkap">Nama Lengkap:</label>
            <input type="text" name="NamaLengkap" required><br><br>

            <label for="Username">Username:</label>
            <input type="text" name="Username" required><br><br>

            <label for="Email">Email:</label>
            <input type="email" name="Email" required><br><br>

            <label for="Password">Password:</label>
            <input type="password" name="Password" required><br><br>

            <label for="Alamat">Alamat:</label>
            <textarea name="Alamat" rows="3" required></textarea><br><br>

            <!-- Pilihan Role (Admin atau User) -->
            <label for="Role">Role:</label>
            <select name="Role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select><br><br>

            <button type="submit">Daftar</button>
        </form>

        <p>Sudah punya akun? <a href="index.php">Login di sini</a></p>
    </section>
</main>

</body>
</html>
