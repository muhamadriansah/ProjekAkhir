<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: index.php");
    exit();
}

include "koneksi.php"; // Koneksi database

// Process like/unlike action
if (isset($_POST['like'])) {
    $fotoID = $_POST['fotoID'];
    $userID = $_SESSION['UserID'];

    // Check if the user has already liked this photo
    $checkLike = "SELECT * FROM likefoto WHERE FotoID = '$fotoID' AND UserID = '$userID'";
    $checkResult = mysqli_query($con, $checkLike);

    if (mysqli_num_rows($checkResult) == 0) {
        // Insert a new like
        $insertLike = "INSERT INTO likefoto (FotoID, UserID, TanggalLike) VALUES ('$fotoID', '$userID', NOW())";
        mysqli_query($con, $insertLike);
    } else {
        // User has already liked, so remove the like (unlike)
        $deleteLike = "DELETE FROM likefoto WHERE FotoID = '$fotoID' AND UserID = '$userID'";
        mysqli_query($con, $deleteLike);
    }
}

// Process comment action
if (isset($_POST['comment'])) {
    $fotoID = $_POST['fotoID'];
    $comment = mysqli_real_escape_string($con, $_POST['commentText']);
    $userID = $_SESSION['UserID'];

    // Insert the comment into the database
    $insertComment = "INSERT INTO komentarfoto (FotoID, UserID, IsiKomentar, TanggalKomentar) 
                      VALUES ('$fotoID', '$userID', '$comment', NOW())";
    mysqli_query($con, $insertComment);
}

// Process search action
$searchKeyword = '';
if (isset($_GET['search'])) {
    $searchKeyword = mysqli_real_escape_string($con, $_GET['search']);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            padding: 20px;
        }
        .gallery-item {
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            width: 200px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .gallery-item img {
            width: 100%;
            height: auto;
        }
        .gallery-item h3 {
            margin: 10px 0;
            font-size: 16px;
        }
        .gallery-item p {
            font-size: 14px;
            color: #555;
        }
        .like-button, .comment-button {
            display: inline-block;
            margin-top: 10px;
            padding: 5px 10px;
            background-color: #333;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .like-button:hover, .comment-button:hover {
            background-color: #555;
        }
        .comment-section {
            margin-top: 20px;
        }
        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px;
        }
        .comment-author {
            font-weight: bold;
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
        .search-bar {
            margin: 20px;
            display: flex;
            justify-content: center;
        }
        .search-bar input[type="text"] {
            padding: 8px;
            width: 300px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }
        .search-bar button {
            padding: 8px 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #555;
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
    <section>
        <h2>Foto yang Telah Diupload</h2>
        <div class="search-bar">
            <form action="gallery.php" method="GET">
                <input type="text" name="search" value="<?php echo $searchKeyword; ?>" placeholder="Search by title or description...">
                <button type="submit">Search</button>
            </form>
        </div>

        <div class="gallery">
            <?php
            // Query to fetch photos based on search
            $searchCondition = '';
            if ($searchKeyword) {
                $searchCondition = "WHERE foto.JudulFoto LIKE '%$searchKeyword%' OR foto.DeskripsiFoto LIKE '%$searchKeyword%'";
            }
            $query = "SELECT foto.FotoID, foto.JudulFoto, foto.DeskripsiFoto, foto.LokasiFoto FROM foto $searchCondition";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $fotoID = $row['FotoID'];

                    // Get the number of likes
                    $likeQuery = "SELECT COUNT(*) AS like_count FROM likefoto WHERE FotoID = '$fotoID'";
                    $likeResult = mysqli_query($con, $likeQuery);
                    $likeData = mysqli_fetch_assoc($likeResult);
                    $likeCount = $likeData['like_count'];

                    // Check if the user has already liked this photo
                    $checkLike = "SELECT * FROM likefoto WHERE FotoID = '$fotoID' AND UserID = '" . $_SESSION['UserID'] . "'";
                    $likeCheckResult = mysqli_query($con, $checkLike);
                    $isLiked = mysqli_num_rows($likeCheckResult) > 0;

                    // Get the comments for this photo
                    $commentQuery = "SELECT komentarfoto.IsiKomentar, user.Username FROM komentarfoto 
                                     INNER JOIN user ON komentarfoto.UserID = user.UserID 
                                     WHERE komentarfoto.FotoID = '$fotoID'";
                    $commentResult = mysqli_query($con, $commentQuery);
                    ?>
                    <div class="gallery-item">
                        <img src="uploads/<?php echo $row['LokasiFoto']; ?>" alt="<?php echo $row['JudulFoto']; ?>">
                        <h3><?php echo $row['JudulFoto']; ?></h3>
                        <p><?php echo $row['DeskripsiFoto']; ?></p>

                        <form action="gallery.php" method="POST">
                            <input type="hidden" name="fotoID" value="<?php echo $fotoID; ?>">
                            <button type="submit" name="like" class="like-button">
                                <i class="fas <?php echo $isLiked ? 'fa-heart' : 'fa-heart-o'; ?>"></i>
                                <?php echo $likeCount; ?>
                            </button>
                        </form>

                        <div class="comment-section">
                            <h4>Comments</h4>
                            <?php while ($comment = mysqli_fetch_assoc($commentResult)) { ?>
                                <div class="comment">
                                    <p class="comment-author"><?php echo htmlspecialchars($comment['Username']); ?>:</p>
                                    <p><?php echo htmlspecialchars($comment['IsiKomentar']); ?></p>
                                </div>
                            <?php } ?>

                            <form action="gallery.php" method="POST">
                                <input type="hidden" name="fotoID" value="<?php echo $fotoID; ?>">
                                <textarea name="commentText" rows="3" placeholder="Add your comment..." required></textarea><br>
                                <button type="submit" name="comment" class="comment-button">Post Comment</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Belum ada foto yang diupload atau tidak ada foto yang cocok dengan pencarian Anda.</p>";
            }
            ?>
        </div>
    </section>
</main>
</body>
</html>
