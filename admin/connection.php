<?php
// Konfigurasi koneksi ke database
$servername = "sql310.infinityfree.com"; // Ganti dengan nama host database Anda
$username = "if0_36642081"; // Ganti dengan username database Anda
$password = "Renkucing01"; // Ganti dengan password database Anda
$database = "if0_36642081_geongame"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} 



?>
