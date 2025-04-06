<?php
session_start();
$is_logged_in = isset($_SESSION['user_id']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Meta Tags -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Crosswords – HSC Exam Style Questions</title>

  <!-- Stylesheets and favicon -->
  <link rel="stylesheet" href="../css/styles.css">
  <link rel="icon" href="../images/logo.png">

</head>
<body>
  <!-- Header Section -->
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

    <!-- Secondary Navigation -->
    <div class="secondary-nav">
      <div class="container">
        <ul>
          <li><a href="https://www.educationstandards.nsw.edu.au/wps/portal/nesa/11-12/Understanding-the-curriculum/syllabuses-a-z" target="_blank">NESA Syllabus</a></li>
          <li><a href="https://educationstandards.nsw.edu.au/wps/portal/nesa/11-12/hsc/key-dates-exam-timetables" target="_blank">Key HSC Dates</a></li>
          <li><a href="crosswords.php" class="crosswords-link">Crosswords</a></li>
        </ul>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <main>
    <!-- Crosswords Section -->
    <section class="crosswords-section">
      <div class="container">
        <h2 class="crosswords-heading">Free Online Crossword Puzzles</h2>

        <h3>Instructions for solving a crossword online:</h3>

        <ul>
          <li>Click a cell on the crossword grid, or click a clue</li>
          <li>Click twice on a cell to toggle between across and down</li>
          <li>The active cell is highlighted in <span class="blue">blue</span></li>
          <li>Start typing in the word</li>
          <li>Hit enter when you are done typing in the word</li>
          <li>The word will turn <span class="green">green</span> or <span class="red">red</span> if you got it right or wrong</li>
          <li>You can use the tab and shift-tab keys to move around the crossword, and the arrow keys</li>
        </ul>

        <div class="crossword-list">
          <a href="https://crosswordlabs.com/embed/engineering-fundamentals-crossword-puzzle-1" target="_blank">Engineering St Puzzle 1</a>
          <a href="https://crosswordlabs.com/embed/ipt-puzzle-1" target="_blank">IPT Puzzle 1</a>
          <a href="https://crosswordlabs.com/embed/biology-puzzle-1-9" target="_blank">Biology Puzzle 1</a>
          <a href="https://crosswordlabs.com/embed/ipt-puzzle-2" target="_blank">IPT Puzzle 2</a>
          <a href="https://crosswordlabs.com/embed/biology-puzzle-2-12" target="_blank">Biology Puzzle 2</a>
          <a href="https://crosswordlabs.com/embed/ipt-puzzle-3" target="_blank">IPT Puzzle 3</a>
          <a href="https://crosswordlabs.com/embed/ipt-puzzle-4" target="_blank">IPT Puzzle 4</a>
          <a href="https://crosswordlabs.com/embed/ipt-puzzle-5" target="_blank">IPT Puzzle 5</a>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
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

  <!-- JavaScript -->
  <script src="../js/main.js"></script>
</body>
</html>
