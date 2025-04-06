<?php
session_start();
//connect to database
include 'db_connect.php';

$error = '';
//Runs the code inside only when the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //temporary save of the input username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    //connect to database
    //prepare() prevents sql injection, treat input as purely data
    //prepare for a safe query to find admin by their username
    $stmt = $conn->prepare("SELECT id, password FROM admins WHERE username = ?");
    //put username back to the query placeholder "?", bind_paran() prevents SQL injection
    $stmt->bind_param("s", $username);
    //Run the query on the database, look for a matching admin from table "admin"
    $stmt->execute();
    //save the query result for later use
    $stmt->store_result();

    //if admin name exsist and only one matches
    if ($stmt->num_rows === 1) {
        //links the query’s columns (id, password) to $id and $hashed_password
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();
        //if password is correct
        if (password_verify($password, $hashed_password)) {
            // Set admin session
            $_SESSION['admin_id'] = $id; 
            //send to admin exclusive page
            header("Location: admin_dashboard.php");
            exit;
        } else {
            //wrong password
            $error = "Invalid password";
        }
    } else {
        //no match 
        $error = "Admin username not found";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – HSC Exam Style Questions</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/logo.png">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="social-links">
                    <a href="https://www.facebook.com/profile.php?id=61557699426262&sk=groups_member" target="_blank">Facebook</a>
                    <a href="https://www.instagram.com/hscrevision/" target="_blank">Instagram</a>
                </div>
            </div>
            <div class="header-main">
                <a href="../index.php" class="logo">
                    <img src="../images/logo.png" alt="HSC Revision Logo">
                    <div class="logo-text">
                        <h1>HSC Exam Style Questions</h1>
                        <p>Self-marking quizzes aligned with the NESA Curriculum</p>
                    </div>
                </a>
                <nav class="main-nav">
                    <ul>
                        <li><a href="../index.php">Home</a></li>
                        <li><a href="#">Revision Sessions</a></li>
                        <li><a href="#">Schools Offer</a></li>
                        <li><a href="#">Free Downloads</a></li>
                        <li><a href="#">Shop</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                    </ul>
                </nav>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="login-link">Profile</a>
                <?php else: ?>
                    <a href="login.php" class="login-link">Log In</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main>
        <section class="auth-section">
            <div class="container">
                <div class="auth-container">
                    <h2 class="section-heading">Admin Login</h2>
                    <?php if (!empty($error)): ?>
                        <div class="error-message" style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form class="auth-form" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="form-btn">Log In</button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-bottom">
                <a href="#">Privacy Policy</a>
                <div class="copyright">Copyright © 2025 HSC Exam Style Questions</div>
                <a href="#">Terms of Use</a>
            </div>
            <div class="footer-nav">
                <ul>
                    <li><a href="../index.php">Home</a></li>
                    <li><a href="#">Revision Sessions</a></li>
                    <li><a href="#">Schools Offer</a></li>
                    <li><a href="#">Free Downloads</a></li>
                    <li><a href="#">Shop</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script src="../js/main.js"></script>
</body>
</html>