<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

include "koneksi.php"; // Koneksi database

// Update action
if (isset($_POST['update'])) {
    $newUsername = mysqli_real_escape_string($con, $_POST['username']);
    $userID = $_SESSION['UserID'];

    // Update username in the database
    $updateQuery = "UPDATE user SET Username = '$newUsername' WHERE UserID = '$userID'";
    if (mysqli_query($con, $updateQuery)) {
        $_SESSION['Username'] = $newUsername; // Update session variable
        echo "<script>
                alert('Username updated successfully.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating username: " . mysqli_error($con) . "');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Account</title>
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

        input[type="text"] {
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
</nav>

<main>
    <h2>Account Setting</h2>
    <form action="akun.php" method="POST">
        <label for="username">New Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($_SESSION['Username']); ?>" required><br><br>

        <button type="submit" name="update">Update Username</button>
    </form>
</main>
</body>
</html>
