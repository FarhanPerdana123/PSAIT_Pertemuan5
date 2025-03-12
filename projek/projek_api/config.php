<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root"; // Sesuaikan dengan user database
$pass = ""; // Sesuaikan dengan password database
$dbname = "projek";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>  