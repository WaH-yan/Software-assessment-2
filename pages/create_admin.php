<?php
include 'db_connect.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT); // Change 'admin123' to a secure password
$stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$stmt->close();
echo "Admin user created!";
?>