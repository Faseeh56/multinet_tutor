<?php
$host = 'localhost';
$user = 'root';      // default XAMPP username
$password = '';      // default XAMPP password (empty)
$database = 'multinet_db';

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>