// Waits for the HTML structure (DOM) to fully load before running the code inside
document.addEventListener('DOMContentLoaded', () => {
  // Logs a confirmation to the console for debugging, showing the DOM is ready
  console.log('DOM fully loaded');

  // Section to kick off the website’s main interactive features
  // Initializes the mobile navigation menu (e.g., hamburger menu toggle)
  handleResponsiveMenu();   
  // Sets up an interactive carousel for featured content or images
  initCarousel();            
  // Activates the FAQ accordion feature on the contact page
  initFAQToggle();          
  // Starts the countdown timer showing days until the HSC exam
  updateCountdown();         

  // Adds a listener to handle changes when the window is resized
  window.addEventListener('resize', () => {
    // Adjusts the carousel’s size to fit the new window dimensions
    resizeCarousel();       
    // Updates the mobile menu to match the new screen size
    handleResponsiveMenu(); 
  });

  // Runs an initial resize to set the carousel’s dimensions right after loading
  resizeCarousel();         
  
  // Sets up form submission logic with client-side checks (e.g., for registration)
  setupFormHandlers();     
});


function handleResponsiveMenu() {
  // Select key navigation and header elements
  const secondaryNav = document.querySelector('.secondary-nav');
  const mainNav = document.querySelector('.main-nav');         
  const headerMain = document.querySelector('.header-main');   
  
  // Check if screen width is mobile (≤ 768px)
  if (window.innerWidth <= 768) {
    // Hide secondary navigation on mobile for simplicity
    if (secondaryNav) {
      secondaryNav.style.display = 'none';
    }

    // Set up main navigation for mobile: hidden by default
    if (mainNav) {
      mainNav.style.display = 'none'; 
      mainNav.classList.remove('active'); 
    }

    // Create menu toggle button if it doesn’t exist
    if (!document.getElementById('mainMenuBtn') && mainNav && headerMain) {
      const menuToggle = document.createElement('button');
      menuToggle.id = 'mainMenuBtn';
      menuToggle.className = 'menu-toggle';
      menuToggle.innerHTML = '☰'; //hamburger
      // Style the button for mobile display
      menuToggle.style.display = 'block';
      menuToggle.style.order = '2';
      menuToggle.style.background = 'none';
      menuToggle.style.border = 'none';
      menuToggle.style.fontSize = '24px';
      menuToggle.style.cursor = 'pointer';
      menuToggle.style.color = 'var(--primary)';
      menuToggle.style.padding = '5px 10px';

      // Position the button after the logo, or adjust if logo is missing
      const logo = document.querySelector('.logo');
      if (logo && logo.nextSibling) {
        headerMain.insertBefore(menuToggle, logo.nextSibling);
      } else if (headerMain.firstChild) {
        headerMain.insertBefore(menuToggle, headerMain.firstChild.nextSibling);
      }

      // Add click event to toggle main navigation visibility
      menuToggle.addEventListener('click', (e) => {
        // Prevent any default button behavior
        e.preventDefault();
        // Toggle active class
        mainNav.classList.toggle('active');
        // Show or hide main nav based on active state
        if (mainNav.classList.contains('active')) {
          mainNav.style.display = 'block'; // Show when active
        } else {
          mainNav.style.display = 'none'; // Hide when inactive
        }
        // Switch button icon: '✕' (close) when active, '☰' (menu) when inactive
        menuToggle.innerHTML = mainNav.classList.contains('active') ? '✕' : '☰';
      });
    }
  } else {
    // Desktop behavior (> 768px): restore full navigation
    if (secondaryNav) {
      // Show secondary nav
      secondaryNav.style.display = 'block';
    }

    // Remove mobile toggle button if it exists
    const menuBtn = document.getElementById('mainMenuBtn');
    if (menuBtn) {
      menuBtn.remove(); // Remove toggle button on desktop
    }

    // Ensure main navigation is visible and styled for desktop
    if (mainNav) {
      // Remove mobile toggle state
      mainNav.classList.remove('active');
      // Use flex for desktop layout
      mainNav.style.display = 'flex'; 
    }
  }
}

//The carousel functionality creates an interactive carousel that has autoplay with a customizable interval, previous and next navigation buttons, indicator dots showing the current slide, touch swipe support for mobile devices, and the ability to pause on hover.
function initCarousel() {
  console.log('Initializing carousel');

  // Get carousel elements
  const carousel = document.getElementById('carousel');
  const carouselIndicators = document.getElementById('carousel-indicators');
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');

  // Only proceed if all required elements exist
  if (carousel && prevButton && nextButton) {
    console.log('Carousel elements found');

    // Get all slides
    const slides = carousel.querySelectorAll('.carousel-slide');
    if (slides.length === 0) {
      console.log('No slides found');
      return;
    }

    console.log('Found', slides.length, 'slides');

    // Track the current slide index, autoplay state, and touch positions
    // Index of the current slide (0-based)
    let currentSlide = 0;           
    // Reference to the autoplay timer
    let autoplayInterval = null;    
    // Starting X position for touch events
    let touchStartX = 0;            
    // Ending X position for touch events
    let touchEndX = 0;              

    //Create indicator dots for the carousel
    //One dot for each slide, with the first one active by default
    if (carouselIndicators) {
      // Clear existing indicators
      carouselIndicators.innerHTML = '';

      slides.forEach((_, index) => {
        // Create an indicator dot
        const indicator = document.createElement('div');
        indicator.classList.add('carousel-indicator');

        // Set the first indicator as active
        if (index === 0) {
          indicator.classList.add('active');
        }

        // Add click event handler to navigate to the corresponding slide
        indicator.addEventListener('click', () => {
          // Go to the clicked slide
          goToSlide(index);  
          // Reset autoplay timer
          resetAutoplay();   
        });

        // Add the indicator to the container
        carouselIndicators.appendChild(indicator);
      });
    }

    // Update the active indicator dots
    // Ensures the indicator matching the current slide is highlighted
    const updateIndicators = () => {
      if (!carouselIndicators) return;

      // Get all indicator dots
      const indicators = carouselIndicators.querySelectorAll('.carousel-indicator');

      // Update active class based on current slide
      indicators.forEach((indicator, index) => {
        if (index === currentSlide) {
          indicator.classList.add('active');
        } else {
          indicator.classList.remove('active');
        }
      });
    };

    const goToSlide = (slideIndex, animate = true) => {
      console.log('Going to slide', slideIndex);
    
      // Remove active class from all slides
      slides.forEach(slide => {
        slide.classList.remove('active');
        // Remove fade-in-text class from all text elements
        const textElements = slide.querySelectorAll('.carousel-content h3, .carousel-content p');
        textElements.forEach(el => el.classList.remove('fade-in-text'));
      });
    
      // Update current slide index
      currentSlide = slideIndex;
    
      // Handle boundary conditions (looping)
      if (currentSlide < 0) {
        currentSlide = slides.length - 1;  // Go to last slide if before first
      } else if (currentSlide >= slides.length) {
        currentSlide = 0;  // Go to first slide if after last
      }
    
      // Set active class for current slide
      slides[currentSlide].classList.add('active');
    
      if (carousel) {
        // Apply transition based on animate parameter
        if (animate) {
          carousel.style.transition = 'transform 0.5s ease';
        } else {
          carousel.style.transition = 'none';  // No animation
        }
    
        // Get the current width of each slide
        const slideWidth = slides[0].offsetWidth;
        carousel.style.transform = `translateX(-${currentSlide * slideWidth}px)`;
    
        // Force reflow to ensure transition applies correctly when needed
        if (!animate) {
          void carousel.offsetHeight; // Force reflow
          carousel.style.transition = 'transform 0.5s ease';
        }
      }
    
      // Add fade-in-text class to the active slide's text elements
      const activeSlide = slides[currentSlide];
      const activeTextElements = activeSlide.querySelectorAll('.carousel-content h3, .carousel-content p');
      activeTextElements.forEach(el => el.classList.add('fade-in-text'));
    
      // Update indicator dots to match current slide
      updateIndicators();
    };

    //Start autoplay for the carousel
    //Changes slides automatically at regular intervals
    const startAutoplay = () => {
      if (autoplayInterval === null) {
        autoplayInterval = window.setInterval(() => {
          goToSlide(currentSlide + 1);  // Go to next slide
        }, 5000); // Change slide every 5 seconds
      }
    };

    //Reset autoplay timer
    //Used after manual navigation to ensure consistent timing
    const resetAutoplay = () => {
      // Clear existing timer if it exists
      if (autoplayInterval !== null) {
        clearInterval(autoplayInterval);
        autoplayInterval = null;
      }

      // Start a new timer
      startAutoplay();
    };

    // Event listeners for navigation buttons
    prevButton.addEventListener('click', () => {
      goToSlide(currentSlide - 1);  // Go to previous slide
      resetAutoplay();  // Reset autoplay timer
    });

    nextButton.addEventListener('click', () => {
      goToSlide(currentSlide + 1);  // Go to next slide
      resetAutoplay();  // Reset autoplay timer
    });

    // Touch events for swipe functionality on mobile
    carousel.addEventListener('touchstart', (e) => {
      // Record the starting touch position
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });  // passive: true improves performance

    carousel.addEventListener('touchend', (e) => {
      // Record the ending touch position
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();  // Process the swipe
    }, { passive: true });  // passive: true improves performance

    
     // Handle swipe gestures on touch devices
     // Allows users to swipe left/right to navigate slides
    const handleSwipe = () => {
      // Minimum distance to trigger swipe
      const swipeThreshold = 50; 
      const swipeDistance = touchEndX - touchStartX;

      if (swipeDistance > swipeThreshold) {
        // Swipe right - go to previous slide
        goToSlide(currentSlide - 1);
        resetAutoplay();
      } else if (swipeDistance < -swipeThreshold) {
        // Swipe left - go to next slide
        goToSlide(currentSlide + 1);
        resetAutoplay();
      }
    };

    // Pause autoplay on hover (to avoid slides changing while reading)
    const carouselContainer = document.querySelector('.carousel-container');
    if (carouselContainer) {
      // Pause on mouse enter
      carouselContainer.addEventListener('mouseenter', () => {
        if (autoplayInterval !== null) {
          clearInterval(autoplayInterval);
          autoplayInterval = null;
        }
      });

      // Resume on mouse leave
      carouselContainer.addEventListener('mouseleave', () => {
        startAutoplay();
      });
    }

    // Set the first slide as active
    slides[0].classList.add('active');
    const initialTextElements = slides[0].querySelectorAll('.carousel-content h3, .carousel-content p');
    initialTextElements.forEach(el => el.classList.add('fade-in-text'));

    // Start the carousel autoplay
    startAutoplay();

    // Initial slide sizing to ensure correct layout
    resizeCarousel();
  } else {
    console.log('Carousel elements not found');
  }
}

//  Resize Carousel for Responsiveness
function resizeCarousel() {
  // Get carousel elements
  const carousel = document.getElementById('carousel');
  const carouselContainer = document.querySelector('.carousel-container');

  // Only proceed if both elements exist
  if (carousel && carouselContainer) {
    // Get all slides
    const slides = carousel.querySelectorAll('.carousel-slide');
    if (!slides.length) return;  // Exit if no slides found

    // Find the currently active slide
    let activeIndex = 0;
    slides.forEach((slide, index) => {
      if (slide.classList.contains('active')) {
        activeIndex = index;
      }
    });

    // Get the container width - this ensures slides match the container width
    const containerWidth = carouselContainer.offsetWidth;

    // Adjust each slide's width to match the container
    slides.forEach(slide => {
      slide.style.width = `${containerWidth}px`;
    });

    // Update the overall carousel width to contain all slides
    carousel.style.width = `${containerWidth * slides.length}px`;

    // Temporarily disable transitions to prevent animation during resize
    carousel.style.transition = 'none';

    // Update the transform to stay on the active slide
    carousel.style.transform = `translateX(-${activeIndex * containerWidth}px)`;

    // Force DOM reflow then reapply transition for future slide changes
    void carousel.offsetHeight;  // Triggers reflow
    carousel.style.transition = 'transform 0.5s ease';
  }
}

// toggle, contact page
function initFAQToggle() {
  console.log('Initializing FAQ toggle');

  // Get all FAQ question elements
  const faqQuestions = document.querySelectorAll('.faq-question');

  if (faqQuestions.length > 0) {
    console.log('Found', faqQuestions.length, 'FAQ items');

    // Add click handlers to each question
    faqQuestions.forEach(question => {
      question.addEventListener('click', () => {
        // Get the associated answer and toggle element
        // The next element after the question
        const answer = question.nextElementSibling;  
        // The +/- icon
        const toggle = question.querySelector('.faq-toggle');  

        // Toggle the answer visibility
        answer.classList.toggle('active');

        // Update the toggle symbol (+ when closed, - when open)
        if (toggle) {
          toggle.textContent = answer.classList.contains('active') ? '-' : '+';
        }
      });
    });
  } else {
    console.log('No FAQ items found');
  }
}

// countdown timer
function updateCountdown() {
  console.log('Updating countdown');

  // Get the countdown element
  const countdownElement = document.getElementById('countdown');

  // Only proceed if the element exists
  if (countdownElement) {
    console.log('Countdown element found');

    // Target date: October 16th, 2025 (HSC exam date)
    const targetDate = new Date('2025-10-16T00:00:00');

    // Calculator function - computes and displays time remaining
    const calculate = () => {
      const currentDate = new Date();
      const difference = targetDate.getTime() - currentDate.getTime();

      // If the target date has passed
      if (difference < 0) {
        countdownElement.innerHTML = `HSC Exams<br>Have begun!`;
        return;
      }

      // Calculate days remaining
      const days = Math.floor(difference / (1000 * 60 * 60 * 24));

      // Update the countdown element with days remaining
      countdownElement.innerHTML = `${days}<br>Days to go!`;

      // Add a tooltip with more detailed info (hours and minutes)
      const hours = Math.floor((difference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
      countdownElement.title = `${days} days, ${hours} hours, and ${minutes} minutes until HSC exams`;
    };

    // Initial update on page load
    calculate();

    // Update countdown hourly
    setInterval(calculate, 3600000); // 1 hour in milliseconds
  } else {
    console.log('Countdown element not found');
  }
}

// Handles login, registration, and profile form submissions with client-side validation
function setupFormHandlers() {
  //Login form handler
  const loginForm = document.getElementById('loginForm');
  if (loginForm) {
      loginForm.addEventListener('submit', (event) => {
          const username = document.getElementById('username').value;
          const password = document.getElementById('password').value;
          
          if (!username || !password) {
              event.preventDefault(); // Stop submission if validation fails
              alert('Please enter your username and password');
          }
          // If validation passes, let the form submit to PHP naturally
      });
  }
  
  // Register form handler
  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
      registerForm.addEventListener('submit', (event) => {
          const username = document.getElementById('username').value;
          const password = document.getElementById('password').value;
          const confirmPassword = document.getElementById('confirmPassword').value;
          const email = document.getElementById('email').value;
          const termsAgree = document.getElementById('termsAgree').checked;

          if (!username || !email || !password) {
              event.preventDefault();
              alert('Please fill in all required fields');
              return;
          }
          if (password !== confirmPassword) {
              event.preventDefault();
              alert('Passwords do not match');
              return;
          }
          if (!termsAgree) {
              event.preventDefault();
              alert('You must agree to the terms and conditions');
              return;
          }
          // If validation passes, let the form submit to PHP naturally
      });
  }

  // Profile form handler
  // Select the form in profile.php
  const profileForm = document.querySelector('.auth-form'); 
  if (profileForm && !loginForm && !registerForm) { 
      profileForm.addEventListener('submit', (event) => {
          const graduationYear = document.getElementById('graduation_year').value;
          const dateOfBirth = document.getElementById('date_of_birth').value;
          const phoneNumber = document.getElementById('phone_number').value;

          // Validate graduation year (if provided)
          if (graduationYear && isNaN(graduationYear)) {
              event.preventDefault();
              alert('Graduation year must be a number.');
              return;
          }

          // Validate date of birth (if provided)
          if (dateOfBirth) {
              const datePattern = /^\d{4}-\d{2}-\d{2}$/;
              if (!datePattern.test(dateOfBirth)) {
                  event.preventDefault();
                  alert('Date of birth must be in YYYY-MM-DD format.');
                  return;
              }
          }

          // Validate phone number (if provided)
          if (phoneNumber) {
              const phonePattern = /^\+?\d{1,4}?\s?\d{3,14}$/;
              if (!phonePattern.test(phoneNumber)) {
                  event.preventDefault();
                  alert('Please enter a valid phone number (e.g., +61 412 345 678).');
                  return;
              }
          }

      });
  }
}

