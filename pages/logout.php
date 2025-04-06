<?php //one of the first few function, logout

session_start();
// end all sessions (user and admin)
session_destroy();
//back to homepage
header("Location: ../index.php");
//done
exit;
?>