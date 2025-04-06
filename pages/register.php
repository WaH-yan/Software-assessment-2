<?php
// Start the PHP block
// Include database connection

include 'db_connect.php'; 

// Array to store validation errors
$errors = []; 

//checks if the form was submitted with POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $termsAgree = isset($_POST['termsAgree']);

    // Basic validation
    //check if email, username, password are empty
    if (empty($email)) {
        $errors[] = "Email is required";
    }

    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }
    //check if the reenter password is same
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match";
    }
    //placeholder ahhh agree
    if (!$termsAgree) {
        $errors[] = "You must agree to the terms and conditions";
    }

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    //look for any matches from database, if found 1 or above, return error
    if ($stmt->num_rows > 0) {
        $errors[] = "Username or email already in use";
    }
    $stmt->close();

    //Checks if there are no errors from earlier
    if (empty($errors)) {
        //hash password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password
        //add user
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        //fill the 3 "?" with strings and previous entries
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        //run inserted query and check success
        if ($stmt->execute()) {
            //if success, go login page
            header("Location: login.php"); 
            exit;
          //else try again
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register – HSC Exam Style Questions</title>
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="icon" href="../images/logo.png">
</head>
<body>

      <!-- Header Main Area -->
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
          <h2 class="section-heading">Register</h2>
          <div class="auth-notice">
            <p>
              Create an account to access our HSC exam preparation quizzes and track your progress.
              If you already have an account, you can <a href="login.php" style="color: white; text-decoration: underline;">login here</a>.
            </p>
          </div>

          <!-- Display errors if any -->
          <?php if (!empty($errors)): ?>
            <div class="error-messages" style="color: red; margin-bottom: 15px;">
              <ul>
                <?php foreach ($errors as $error): ?>
                  <li><?php echo $error; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form class="auth-form" id="registerForm" method="post">
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
              <small class="form-text">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
              <small class="form-text">Your username will be shown in your account profile.</small>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
              <label for="confirmPassword">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="termsAgree" name="termsAgree" required>
              <label for="termsAgree">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a></label>
            </div>
            <button type="submit" class="form-btn">Register</button>
          </form>
          <div class="auth-links">
            <p>Already have an account? <a href="login.php">Login</a></p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <!-- (Keep your existing footer HTML unchanged) -->
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