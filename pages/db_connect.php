<?php
// included in other files, useful and one of the first few developed functions

//creates a new database connection, hsc_review database
$conn = new mysqli('localhost', 'root', 'root', 'hsc_revision');

//touchwood
if ($conn->connect_error) {
    //stop scipt and show fail
    die("Connection failed: " . $conn->connect_error);
}
?>