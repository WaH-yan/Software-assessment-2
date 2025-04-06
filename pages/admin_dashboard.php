<?php
session_start();
// Connects to the database for user data
include 'db_connect.php';

//check whether the current user is logged in as an admin by checking the $_SESSION['admin_id'] variable.
if (!isset($_SESSION['admin_id'])) {
    // Redirects to the login page if not logged in as an admin.
    header("Location: admin_login.php");
    exit;
}

// prepare a query of the user from database
$stmt = $conn->prepare("SELECT id, username, graduation_year, email, is_banned FROM users");
//Runs the query on the database.
$stmt->execute();
//take the query results as a result.
$result = $stmt->get_result();
//Fetches all rows from the result set and stores them in an array, will be used later
$users = $result->fetch_all(MYSQLI_ASSOC);
//Closes the prepared statement to free up resources.
$stmt->close();
?>

<!-- again nav and footer -->
<!DOCTYPE html>
<html lang="en">
<script src="../js/main.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard – HSC Exam Style Questions</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../images/logo.png">
    <!-- jQuery, Javascript, frameworks -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                <a href="logout.php" class="login-link">Log Out</a>
            </div>
        </div>
    </header>

    <main>
        <section class="auth-section">
            <div class="container">
                <div class="auth-container">
                    <h2 class="section-heading">User List</h2>
                    <table class="admin-table">
                        <thead>
                            <tr class="admin-tr">
                                <th class="admin-th">Username</th>
                                <th class="admin-th">Graduation Year</th>
                                <th class="admin-th">Email</th>
                                <th class="admin-th">Ban Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- loop through every user, call out every of them -->
                            <?php foreach ($users as $user): ?>
                                <tr class="admin-tr">
                                    <!-- htmrspecialchars() convert special characters into their respective HTML entities, prevent weird code issues. -->
                                    <td class="admin-td"><?php echo htmlspecialchars($user['username']); ?></td>
                                    <!-- if empty, show n/a -->
                                    <td class="admin-td"><?php echo htmlspecialchars($user['graduation_year'] ?? 'N/A'); ?></td>
                                    <td class="admin-td"><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td class="admin-td">
                                        <!-- call the is_banned . If user is banned, dispay unban button, vice versa -->
                                        <?php if ($user['is_banned'] == 1): ?>
                                            <button class="unban-btn" data-user-id="<?php echo $user['id']; ?>">Unban</button>
                                        <?php else: ?>
                                            <button class="ban-btn" data-user-id="<?php echo $user['id']; ?>">Ban</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <!-- end loop -->
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>


    <!-- same footer -->
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

    <!-- im lazy I dun want to move the pages everywhere and split into parts now -->
     <!-- when the ban/unban button is set, clicking it send a request to server to change the ban status (binary) in the database -->
    <script> 
        // wait for the webpage to load fully before running the rest codes
        //$ for jQuery stuff
        $(document).ready(function() {
            //link to style class, when btn is clicked, do the code below:
            $('.ban-btn, .unban-btn').on('click', function() {
                //$(this) refers to the ban/unban click button, 
                var button = $(this);
                //link the user id with the button, from the database rows. Identify which user we are banning/unbanning
                var userId = button.data('user-id');
                //decide to ban or unban base on the current button class.
                var action;
                //If button is a ban button, set action to 1 (ban)
                if (button.hasClass('ban-btn')) {
                    action = 1;
                //If button not a ban button, set action to 0 (unban)
                } else {
                    action = 0;
                }


                // send request to database to ban user
                //jQuery method to send data to the server and get a response.
                $.ajax({
                    //tell server that there will be request to change variables
                    type: 'POST',
                    //send the request there
                    url: 'ban_user.php',
                    //Sends the user’s ID and ban status to the server.
                    data: { user_id: userId, is_banned: action },
                    success: function(response) {
                        if (response === 'success') {
                            //user is previously banned
                            if (action === 1) {
                                //button becomes unban button (allows for unban)
                                button.text('Unban').removeClass('ban-btn').addClass('unban-btn');
                            } else {
                                //if user is not banned, show a ban button to ban them
                                button.text('Ban').removeClass('unban-btn').addClass('ban-btn');
                            }
                        //touchwood
                        } else {
                            //show error and reason
                            alert('Failed to update ban status: ' + response);
                        }
                    },
                    //just in case ajax fails
                    error: function() {
                        //annoucement of debug time
                        alert('An error occurred');
                    }
                });
            });
        });
    </script>
</body>
</html>