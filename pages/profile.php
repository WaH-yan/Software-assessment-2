<?php
session_start();
include 'db_connect.php'; // Include your database connection

// check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//get logged in user_id 
$user_id = $_SESSION['user_id'];
//just in case if it fails, array for error message
$errors = [];
$success = '';

//prepare a query to get user data
$stmt = $conn->prepare("SELECT username, email, graduation_year, date_of_birth, phone_number FROM users WHERE id = ?");
//bind $user_id integer to the query
$stmt->bind_param("i", $user_id);
$stmt->execute();
//link query to results
$stmt->bind_result($username, $email, $graduation_year, $date_of_birth, $phone_number);
$stmt->fetch();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //gets/saves the field and cleans the input from the form.
    $graduation_year = trim($_POST['graduation_year']);
    $date_of_birth = trim($_POST['date_of_birth']);
    $phone_number = trim($_POST['phone_number']);

    // Validate that all fields are filled
    //if field is empty, it returns with an error message
    if (empty($graduation_year)) {
        $errors[] = "Graduation year is required.";
    }
    if (empty($date_of_birth)) {
        $errors[] = "Date of birth is required.";
    }
    if (empty($phone_number)) {
        $errors[] = "Phone number is required.";
    }



    // Update the database if no errors
    if (empty($errors)) {
        // Convert empty date_of_birth to NULL for the database
        $date_of_birth = !empty($date_of_birth) ? $date_of_birth : null;

        $stmt = $conn->prepare("UPDATE users SET graduation_year = ?, date_of_birth = ?, phone_number = ? WHERE id = ?");
        $stmt->bind_param("issi", $graduation_year, $date_of_birth, $phone_number, $user_id);
        if ($stmt->execute()) {
            $success = "Profile updated successfully!";
            // Refresh the displayed data
            $graduation_year = $_POST['graduation_year'];
            $date_of_birth = $_POST['date_of_birth'];
            $phone_number = $_POST['phone_number'];
        } else {
            $errors[] = "Failed to update profile. Please try again.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!-- old friend -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Update Profile – HSC Exam Style Questions</title>
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
                    <h2 class="section-heading">Update Profile</h2>
                    
                    <!-- check $success response, if true, display success message -->
                    <?php if (!empty($success)): ?>
                        <div class="success-message" style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <!-- vice versa -->
                    <?php if (!empty($errors)): ?>
                        <div class="error-messages" style="color: red; margin-bottom: 15px;">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form class="auth-form" method="post">
                        <div class="form-group">
                            <label for="username">Username (cannot be changed)</label>
                            <input type="text" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email">Email (cannot be changed)</label>
                            <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="graduation_year">Graduation Year <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="graduation_year" name="graduation_year" value="<?php echo htmlspecialchars($graduation_year ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth <span style="color: red;">*</span></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth ?? ''); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="phone_number">Phone Number <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number ?? ''); ?>" required>
                        </div>
                        <button type="submit" class="form-btn">Update Profile</button>
                        <a href="logout.php">Log Out</a>
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
</body>
</html>