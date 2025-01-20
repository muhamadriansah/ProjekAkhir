<?php
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['Username']) || !isset($_SESSION['UserID'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';  // Change if necessary
$username = 'root';   // Your database username
$password = '';       // Your database password
$dbname = 'gallerydb'; // Change to your actual database name

// Create connection
$con = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']);
    $message = mysqli_real_escape_string($con, $_POST['message']);

    // Insert message into the database or process as needed
    $query = "INSERT INTO messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    $result = mysqli_query($con, $query);

    // Redirect back to the contact page with a success parameter
    if ($result) {
        header("Location: contact.php?success=true");
    } else {
        // Handle the error (e.g., if the insert fails)
        header("Location: contact.php?success=false");
    }
    exit();
}
?>
