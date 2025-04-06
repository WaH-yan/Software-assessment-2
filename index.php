<!--check if user logged in or not-->
<?php
// create new or resumes an existing session
session_start(); 
//checks if user is logged in and send the result (true/false) to the variable $is_logged_in.
$is_logged_in = isset($_SESSION['user_id']);
?>

<!-- document type declaration, HTML5 -->
<!DOCTYPE html>
<!-- language english -->
<html lang="en">
<!-- JavaScript include -->
<script src="js/main.js"></script>

<head>
  <!-- display of the website nme on the brower's title -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>HSC Exam Style Questions – Self-marking quizzes aligned with the NESA Curriculum</title>

  <!-- icon -->
  <link rel="stylesheet" href="css/styles.css">
  <link rel="icon" href="images/logo.png">
</head>

<!-- begin of nav bar -->
<body>
  <header class="header">
    <div class="container">
      
      <!-- social media nav bar -->
      <div class="header-top">
        <div class="social-links">
          <!-- links which connects to websites -->
          <a href="https://www.facebook.com/profile.php?id=61557699426262&sk=groups_member" target="_blank">Facebook</a>
          <a href="https://www.instagram.com/hscrevision/" target="_blank">Instagram</a>
        </div>
      </div>

      <!-- Nav Main Area -->
      <div class="header-main">
        <!-- link to the index.php file -->
        <a href="index.php" class="logo">
          <!-- logo of the website -->
          <img src="images/logo.png" alt="HSC Revision Logo">
          <div class="logo-text">
            <!-- Title of the website -->
            <h1>HSC Exam Style Questions</h1>
            <p>Self-marking quizzes aligned with the NESA Curriculum</p>
          </div>
        </a>

        <!-- main part of the nav bar (middle) -->
        <nav class="main-nav">
          <ul>
            <!-- dummy links for some of them -->
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Revision Sessions</a></li>
            <li><a href="#">Schools Offer</a></li>
            <li><a href="#">Free Downloads</a></li>
            <li><a href="#">Shop</a></li>
            <li><a href="pages/contact.php">Contact Us</a></li>
          </ul>
        </nav>

        <!-- check login status to decide to display profile or login -->
         <!-- If statment, check user logged in for not by verifying use_id -->
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Displays a "Profile" link to the profile page if the user is logged in. -->
          <a href="pages/profile.php" class="login-link">Profile</a>
        <?php else: ?>
          <!-- the other way around, with "login" link -->
          <a href="pages/login.php" class="login-link">Log In</a>
        <?php endif; ?>
      </div>
    </div>

    <!-- Secondary Navigation -->
    <div class="secondary-nav">
      <div class="container">
        <ul>
          <!-- links that go outside of the website (except crossword)-->
          <li><a href="https://www.educationstandards.nsw.edu.au/wps/portal/nesa/11-12/Understanding-the-curriculum/syllabuses-a-z" target="_blank">NESA Syllabus</a></li>
          <li><a href="https://educationstandards.nsw.edu.au/wps/portal/nesa/11-12/hsc/key-dates-exam-timetables" target="_blank">Key HSC Dates</a></li>
          <li><a href="pages/crosswords.php" class="crosswords-link">Crosswords</a></li>
        </ul>
      </div>
    </div>
  </header>





  <!-- Main Content Area -->
  <main>
    <!-- introduction of the webite -->
    <section class="hero-section">
      <div class="container">
        <table class="hero-table">
          <tr>
            <!-- intro text -->
            <td class="hero-text-cell">
              <h2 class="hero-heading">Are you ready for your HSC exams?</h2>
              <p class="hero-description">
                Check your exam readiness by taking our self-marking quizzes. Our quizzes are written by experienced HSC teachers
                and checked by AI, ensuring they are accurate, rigorous, and perfectly aligned with the NESA HSC syllabus.
                Each question includes a <span class="hint-text">HINT</span> to help you recall the key concepts necessary to answer the question.
                Try the <span class="free-text">FREE sample quizzes</span> below.
              </p>
            </td>
            <!-- end of the world countdown -->
            <td class="countdown-cell">
              <h3 class="written-exams-heading">2025 HSC Written Exams</h3>
              <div class="countdown-box" id="countdown">
                207<br>Days to go!
              </div>
            </td>
          </tr>
        </table>

        <!-- Carousel  -->
        <div class="carousel-blue-container">
          <!-- link to the javascript -->
          <div class="carousel" id="carousel">
            <!-- Slide 1 -->
            <div class="carousel-slide">
              <div class="carousel-content">
                <h3>Mordern Desgin</h3>
                <p>New design, More convenience</p>
              </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-slide">
              <div class="carousel-content">
                <h3>No fancy functions</h3>
                <p>best UX avaliable for every user</p>
              </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-slide">
              <div class="carousel-content">
                <h3>Instant results</h3>
                <p>Localhost immediate load, sorry if you cannot access</p>
              </div>
            </div>
            <!-- Slide 4 -->
            <div class="carousel-slide">
              <div class="carousel-content">
                <h3>Free Sources Access</h3>
                <p>If you can find any</p>
              </div>
            </div>
          </div>

          <!-- Carousel left and right button -->
          <div class="carousel-controls">
            <button class="carousel-button prev-button">&lt;</button>
            <button class="carousel-button next-button">&gt;</button>
          </div>

          <!-- Carousel Indicators -->
          <div class="carousel-indicators" id="carousel-indicators">
            <!-- Indicators will be added by JavaScript -->
          </div>
        </div>
      </div>
    </section>

    <!-- Quizzes Section -->
    <section class="quizzes-section">
      <div class="container">
        <h2 class="quizzes-heading">Quizzes</h2>

        <div class="quizzes-grid">
          <!-- Free Sample Quizzes -->
          <div class="quiz-card">
            <div class="quiz-price free-label">Free</div>
            <img src="https://ext.same-assets.com/831838817/3036425962.jpeg" alt="Free Sample Quizzes">
            <div class="quiz-card-content">
              <h3 class="quiz-title">Free Sample Quizzes</h3>
              <p>Try before you buy</p>
              <a href="https://hscrevision.com/courses/sample-quizzes/" class="quiz-btn">Continue Study</a>
            </div>
          </div>

          <!-- HSC Biology Quiz -->
          <div class="quiz-card">
            <div class="quiz-price">A$59.99</div>
            <img src="https://ext.same-assets.com/831838817/1712352342.jpeg" alt="HSC Biology Quiz">
            <div class="quiz-card-content">
              <h3 class="quiz-title">HSC Biology Quiz</h3>
              <a href="https://hscrevision.com/courses/year-12-biology/" class="quiz-btn">Enroll Now</a>
            </div>
          </div>

          <!-- HSC Business Studies Quiz -->
          <div class="quiz-card">
            <div class="quiz-price">A$59.99</div>
            <img src="https://ext.same-assets.com/831838817/190830552.jpeg" alt="HSC Business Studies Quiz">
            <div class="quiz-card-content">
              <h3 class="quiz-title">HSC Business Studies Quiz</h3>
              <a href="https://hscrevision.com/courses/year-12-business-studies/" class="quiz-btn">Enroll Now</a>
            </div>
          </div>

          <!-- HSC Community and Family Studies Quiz -->
          <div class="quiz-card">
            <div class="quiz-price">A$59.99</div>
            <img src="https://ext.same-assets.com/831838817/206865132.jpeg" alt="HSC Community and Family Studies Quiz">
            <div class="quiz-card-content">
              <h3 class="quiz-title">HSC Community and Family Studies Quiz</h3>
              <a href="https://hscrevision.com/courses/year-12-community-and-family-studies/" class="quiz-btn">Enroll Now</a>
            </div>
          </div>
        </div>

        <!-- text -->
        <p>
          Access to the subscription courses is terminated at the end of the current academic year. Enjoy access to a full year's course,
          with pricing more affordable than hiring a tutor for an hour. Teacher access remains <strong>FREE</strong> for schools that buy
          class subscriptions. Send your inquiries to <strong><a href="mailto:admin@hscrevision.com.au">admin@hscrevision.com.au</a></strong>
        </p>

        <p>
          To report issues, send a screenshot of any problems (subscriptions, typos, etc.) to our admin email. Heads up, DET users!
          Our emails might be in your <strong>SPAM</strong> folder. Mark our emails as <strong>SAFE</strong> so you don't miss anything!
          If you believe that our content is useful to other students, please spread the word so that they can also take advantage of this.
        </p>

        <!-- Good luck message -->
        <div class="good-luck-message">
          <h3>HSC written exams start on Thursday 16th October 2025</h3>
          <h3>We wish you good luck with your studies!</h3>
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
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Revision Sessions</a></li>
          <li><a href="#">Schools Offer</a></li>
          <li><a href="#">Free Downloads</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="pages/contact.php">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>
</html>
