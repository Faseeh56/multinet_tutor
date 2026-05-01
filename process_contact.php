<?php
// Include database connection
include('config.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // SQL query to insert data
    $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Success: redirect back to contact page with success flag
        header('Location: contact.php?status=success');
    } else {
        // Error: redirect with error flag
        header('Location: contact.php?status=error');
    }
} else {
    // If someone tries to access this file directly (not via POST), redirect to contact page
    header('Location: contact.php');
}

// Close connection
mysqli_close($conn);
?>