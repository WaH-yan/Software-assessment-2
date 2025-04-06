<?php
// called by the AJAX in admin_dashboard.php when an admin clicks "Ban" or "Unban"
//changes a user’s ban status securely and tells the front end if it worked
//Updates a user’s ban status in the database if the admin’s request is legit, returning "success" or an error
session_start();
include 'db_connect.php';

// Tells PHP to report every possible error it finds.
error_reporting(E_ALL);
//display errors
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $is_banned = $_POST['is_banned'];

    //connect to database and prepare query(is banned, id), "?" prevent sql injection
    $stmt = $conn->prepare("UPDATE users SET is_banned = ? WHERE id = ?");
    //links the "?" with variable, ii specifies it is integer
    $stmt->bind_param("ii", $is_banned, $user_id);
    
    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error: ' . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>