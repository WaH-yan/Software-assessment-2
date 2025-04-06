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
  <title>Contact Us – HSC Exam Style Questions</title>

  <!-- Stylesheets and favicon -->
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
    <!-- Contact Section -->
    <section class="contact-section">
      <div class="container">
        <h2 class="contact-heading">Contact us via email</h2>

        <p class="contact-text">
          At hscrevision, we hold school teachers in high regard, recognising them as authorities and specialists in their fields.
          As a reflection of this respect, we provide them with unhindered access to quizzes relevant to their subject areas
          when their classes subscribe. In our ongoing commitment to maintaining superior standards, we encourage both teachers
          and users to identify any inaccuracies in the content, including plagiarism, incorrect images, calculations, or
          material that exceeds the specified syllabus.
        </p>

        <p class="contact-text">
          Please send us an email at <strong><a href="mailto:admin@hscrevision.com.au">admin@hscrevision.com.au</a></strong>, attaching a screenshot of your concern.
          A heads up to our DET users: our emails might be in your <strong>SPAM</strong> folder. Mark us as
          <strong>SAFE</strong> so you don't miss our communications.
        </p>

        <!-- FAQ Section -->
        <h2 class="faqs-heading">FAQS</h2>

        <div class="faq-item">
          <div class="faq-question">
            Can I get a refund? <span class="faq-toggle">+</span>
          </div>
          <div class="faq-answer">
            Yes, if for some reason, you need a refund, just contact us via the contact us page. No questions asked.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            What do I do if I do not agree with an answer provided? <span class="faq-toggle">+</span>
          </div>
          <div class="faq-answer">
            Email us with your concern. There may be an error that needs to be looked at. Take a photo of the question
            so that it is easy to located on our database.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            How much time do I need to devote with the quiz? <span class="faq-toggle">+</span>
          </div>
          <div class="faq-answer">
            As much as you like.
          </div>
        </div>

        <div class="faq-item">
          <div class="faq-question">
            Do I need to download an extra software? <span class="faq-toggle">+</span>
          </div>
          <div class="faq-answer">
            No, the quizzes will work on all Windows, Apple and other android devices, including your mobile phones.
          </div>
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