<?php
session_start();
// Include your database connection file
include 'db_connect.php'; 

 // Variable to store error messages
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //store username and password input
    $login_input = $_POST['username']; 
    $password = $_POST['password'];

    // Prepare a query to fetch user data, including ban status
    $stmt = $conn->prepare("SELECT id, password, is_banned FROM users WHERE username = ? OR email = ?");
    //fill the "?" with the stored username and password above, 2 strings ss
    $stmt->bind_param("ss", $login_input, $login_input);
    //runs the query on the database
    $stmt->execute();
    //saves the query results for later use
    $stmt->store_result();

    // Check if the user exists, only 1 should exsist
    if ($stmt->num_rows === 1) {
      //link the query result to variable
        $stmt->bind_result($id, $hashed_password, $is_banned);
        $stmt->fetch();

        // Verify the password
        //if valid, return true
        if (password_verify($password, $hashed_password)) {
            // Check if the user is banned, 0=not ban, 1=ban
            if ($is_banned == 0) {
                // User is not banned, proceed with login
                $_SESSION['user_id'] = $id; 
                header("Location: ../index.php"); // Redirect to homepage
                exit;
                //is_banned = 1
            } else {
                // User is banned
                $error = "Your account has been banned. Please contact support.";
            }
        // passward false
        } else {
            $error = "Invalid password.";
        }
    //no user match $login_input
    } else {
        $error = "Username or email not found.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- old friend -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login – HSC Exam Style Questions</title>
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
          <h2 class="section-heading">My Account</h2>
          <div class="auth-notice">
            <p>
              Login to access your purchased quizzes, track your progress, and continue your HSC exam preparation.
              If you don't have an account yet, you can <a href="register.php" style="color: white; text-decoration: underline;">register here</a>.
            </p>
          </div>

          <!-- Display error if any -->
          <?php if ($error): ?>
               <p style="color: red;"><?php echo $error; ?></p>
          <?php endif; ?>

          <form class="auth-form" id="loginForm" method="post">
            <div class="form-group">
              <label for="username">Username or email address</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            
            <button type="submit" class="form-btn">Log in</button>
          </form>
          <div class="auth-links">

            <p>Don't have an account? <a href="register.php">Register</a></p>
            <li><a href="../pages/admin_login.php">Admin Login</a></li>
          </div>
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