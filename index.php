<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- 
    - primary meta tags
  -->
  <title>CPC - home</title>
  <meta name="title" content="CPC - home">
  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">
  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/hero-banner.png">
  <link rel="preload" as="image" href="./assets/images/hero-bg.png">
</head>
<body id="top">
  <!-- 
    - #PRELOADER
  -->
  <div class="preloader" data-preloader>
    <div class="circle"></div>
  </div>
  <!-- 
    - #HEADER
  -->
  <header class="header" data-header>
    <div class="container">
      <a href="#" class="logo">
        <img src="WhatsApp Image 2024-04-23 at 19.11.56_940cb2e8.jpg" width="206" height="56" alt="CPC home">
      </a>
      <nav class="navbar" data-navbar>
        <div class="navbar-top">
          <a href="#" class="logo">
            <img src="WhatsApp Image 2024-04-23 at 19.11.56_940cb2e8.jpg" width="136" height="46" alt="CPC home">
          </a>
          <button class="nav-close-btn" aria-label="clsoe menu" data-nav-toggler>
            <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
          </button>
        </div>
        <ul class="navbar-list">
          <li class="navbar-item">
            <a href="#" class="navbar-link title-md">Home</a>
          </li>
          <li class="navbar-item">
            <a href="#doctor" class="navbar-link title-md">Doctors</a>
          </li>
          <li class="navbar-item">
            <a href="#service" class="navbar-link title-md">Services</a>
          </li>
          <li class="navbar-item">
            <a href="#blog" class="navbar-link title-md">Blog</a>
          </li>
          <li class="navbar-item">
            <a href="#contact" class="navbar-link title-md">Contact</a>
          </li>
        </ul>
        <ul class="social-list">
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-pinterest"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-youtube"></ion-icon>
            </a>
          </li>
        </ul>
      </nav>
      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <ion-icon name="menu-outline"></ion-icon>
      </button>
      <a class="btn has-before title-md">Make Appointment</a> <!--backend login page-->
      
      <a href="register.php" class="btn has-before title-md">Login</a><!--backend login page-->
      <div class="overlay" data-nav-toggler data-overlay></div>
    </div>
  </header>
  <main>
    <article>
      <!-- 
        - #HERO
      -->
      <section id="doctor" class="section hero" style="background-image: url('./assets/images/hero-bg.png')" aria-label="home">
        <div class="container">
          <div class="hero-content">
            <p class="hero-subtitle has-before" data-reveal="left">Welcome To CPC</p>
            <h1 class="headline-lg hero-title" data-reveal="left">
              Find Nearest <br>
              Doctor.
            </h1>
            <div class="hero-card" data-reveal="left">
              <p class="title-lg card-text">
                Search doctors. clinics. etc.
              </p>
              <div class="wrapper">
                <div class="input-wrapper title-lg">
                  <input type="text" name="location" placeholder="Locations" class="input-field">
                  <ion-icon name="location"></ion-icon>
                </div>
                <button class="btn has-before">
                  <ion-icon name="search"></ion-icon>
                  <span class="span title-md">Find Now</span>
                </button>
              </div>
            </div>
          </div>
          <figure class="hero-banner" data-reveal="right">
            <img src="./assets/images/hero-banner.png" width="590" height="517" loading="eager" alt="hero banner"
              class="w-100">
          </figure>
        </div>
      </section>
      <!-- 
        - #SERVICE
      -->
      <section id="service" class="service" aria-label="service">
        <div class="container">
          <ul class="service-list">
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-1.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Public Health</a>
                </h3>
                <p class="card-text">
                  Embark on a journey towards mental wellness with our compassionate psychiatry services, available at the Public Health Clinic. Our team is dedicated to unraveling your unique narrative and empowering your mind's fullest potential. Take the first step towards mental well-being today.</p>
                <a class="btn-circle" aria-label="read more about psychiatry">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-2.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Dentistry </a>
                </h3>
                <p class="card-text">
                  At the Dentistry Clinic, we understand the importance of holistic health, including mental well-being. That's why we offer compassionate psychiatry services to support you on your journey towards mental wellness. Let us help you unravel your unique narrative and empower your mind's fullest potential. </p>
                <a  class="btn-circle" aria-label="read more about Gynecology">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
            
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-5.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">ENT</a>
                </h3>
                <p class="card-text">
                  Your journey towards mental wellness begins at the Ear, Nose, Throat (ENT) Clinic. Our compassionate psychiatry services are tailored to unravel your unique narrative and empower your mind's fullest potential. Take the step towards comprehensive health care by addressing both physical and mental well-being.</p>
                <a class="btn-circle" aria-label="read more about Orthopedics">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-4.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Cardiology </a>
                </h3>
                <p class="card-text">
                  Mental wellness is integral to overall health, and at the Cardiology Clinic, we prioritize your well-being in every aspect. Our psychiatry services are compassionate and tailored to unravel your unique narrative, empowering your mind's fullest potential alongside your heart health. </p>
                <a  class="btn-circle" aria-label="read more about Orthopedics">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li><li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-7.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Physical Therapy </a>
                </h3>
                <p class="card-text">
                  At the Physical Therapy Clinic, we understand the importance of a holistic approach to health. That's why we offer psychiatry services focused on unraveling your unique narrative and empowering your mind's fullest potential. Take the next step towards comprehensive wellness by addressing both physical and mental well-being. </p>
                <a  class="btn-circle" aria-label="read more about Orthopedics">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-6.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Laboratory </a>
                </h3>
                <p class="card-text">
                  Mental wellness is a vital component of overall health, and our Laboratory Services are committed to supporting your journey towards well-being. Explore our psychiatry services, tailored to unravel your unique narrative and empower your mind's fullest potential. Your health matters to us in every aspect. </p>
                <a class="btn-circle" aria-label="read more about Orthopedics">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
            <li>
              <div class="service-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-3.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <h3 class="headline-sm card-title">
                  <a href="#">Pharmacy</a>
                </h3>
                <p class="card-text">
                  Beyond prescriptions, our Pharmacy is dedicated to supporting your holistic health, including mental well-being. Discover our psychiatry services, designed to unravel your unique narrative and empower your mind's fullest potential. Take the step towards comprehensive wellness with us.</p>
                <a  class="btn-circle" aria-label="read more about Pulmonology">
                  <button>
                    <ion-icon name="arrow-forward" aria-hidden="true"></ion-icon>
                  </button>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </section>
      <!-- 
        - #ABOUT
      -->
      <section id="about" class="section about" aria-labelledby="about-label">
        <div class="container">
          <div class="about-content">
            <p class="section-subtitle title-lg has-after" id="about-label" data-reveal="left">About Us</p>
            <h2 class="headline-md" data-reveal="left">Experienced Workers</h2>
            <p class="section-text" data-reveal="left">
              Our dedicated team, united by a passion for care, works tirelessly to ensure every procedure is performed
              with precision and empathy. From the welcoming reception at our doors to the detailed care in our
              treatment rooms, every step of your journey with us is designed with your well-being in mind.
            </p>
            <ul class="tab-list" data-reveal="left">
              <li>
                <button class="tab-btn active">Vision</button>
              </li>
              <li>
                <button class="tab-btn">Mission</button>
              </li>
              <li>
                <button class="tab-btn">Strategy</button>
              </li>
            </ul>
            <p class="tab-text" data-reveal="left">
              At the core of our ethos, we embrace innovation and compassion, ensuring that every patient's experience
              is both comforting and state-of-the-art. Our dedicated staff are at the forefront, transforming healthcare
              with a blend of expertise and genuine care.
            </p>
            <div class="wrapper">
              <ul class="about-list">
                <li class="about-item" data-reveal="left">
                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                  <span class="span">Comprehensive care with a human touch.</span>
                </li>
                <li class="about-item" data-reveal="left">
                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                  <span class="span">Progressive solutions to advance your well-being.</span>
                </li>
                <li class="about-item" data-reveal="left">
                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                  <span class="span">Meticulous attention to your health needs.</span>
                </li>
                <li class="about-item" data-reveal="left">
                  <ion-icon name="checkmark-circle-outline"></ion-icon>
                  <span class="span">A commitment to excellence in medical services.</span>
                </li>
              </ul>
            </div>
          </div>
          <figure class="about-banner" data-reveal="right">
            <img src="./assets/images/about-banner.png" width="554" height="678" loading="lazy" alt="about banner"
              class="w-100">
          </figure>
        </div>
      </section>
      <!-- 
        - #LISTING
      -->
      <section  class="section listing" aria-labelledby="listing-label">
        <div class="container">
          <ul class="grid-list">
            <li>
              <p class="section-subtitle title-lg" id="listing-label" data-reveal="left">Doctors Listig</p>
              <h2 class="headline-md" data-reveal="left">Browse by specialist</h2>
            </li>
            <li>
              <div class="listing-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-1.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <div>
                  <h3 class="headline-sm card-title">Public Health</h3>
                  <p class="card-text">Community wellness and preventive care</p>
                </div>
              </div>
            </li>
            <li>
              <div class="listing-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-2.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <div>
                  <h3 class="headline-sm card-title">Dentistry </h3>
                  <p class="card-text">Expert dental care for bright smiles</p>
                </div>
              </div>
            </li>
            <li>
              <div class="listing-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-5.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <div>
                  <h3 class="headline-sm card-title">ENT</h3>
                  <p class="card-text">Specialized care for Ear, Nose, Throat(ENT) disorders</p>
                </div>
              </div>
            </li>
            <li>
              <div class="listing-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-4.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <div>
                  <h3 class="headline-sm card-title">Cardiology </h3>
                  <p class="card-text">Advanced heart health services</p>
                </div>
              </div>
            </li>
            <li>
              <div class="listing-card" data-reveal="bottom">
                <div class="card-icon">
                  <img src="./assets/images/icon-7.png" width="71" height="71" loading="lazy" alt="icon">
                </div>
                <div>
                  <h3 class="headline-sm card-title">Physical Therapy </h3>
                  <p class="card-text">Rehabilitation and mobility improvement</p>
                </div>
              </div>
            </li>
           
          </ul>
        </div>
      </section>
      <!-- 
        - #BLOG
      -->
      <section id="blog" class="section blog" aria-labelledby="blog-label">
        <div class="container">
          <p class="section-subtitle title-lg text-center" id="blog-label" data-reveal="bottom">
            News & Article
          </p>
          <h2 class="section-title headline-md text-center" data-reveal="bottom">Latest Articles</h2>
          <ul class="grid-list">
            <li>
              <div class="blog-card has-before has-after" data-reveal="bottom">
                <div class="meta-wrapper">
                  <div class="card-meta">
                    <ion-icon name="person-outline"></ion-icon>
                    <span class="span">By Admin</span>
                  </div>
                  <div class="card-meta">
                    <ion-icon name="folder-outline"></ion-icon>
                    <span class="span">Specialist</span>
                  </div>
                </div>
                <h3 class="headline-sm card-title">Exploring the Potential: Can Intermittent Fasting Diminish the Risk
                  of Breast Cancer?</h3>
                <time class="title-sm date" datetime="2022-01-28">Unveiling the Connections - January 28, 2022 </time>
                <p class="card-text">
                  Dive into the world of preventive health as we discuss the intriguing correlation between intermittent
                  fasting and breast cancer reduction. Our specialists share insights from the latest research,
                  exploring how time-restricted eating could potentially offer protective benefits against this common
                  cancer.
                </p>
                <a href="article1.html" class="btn-text title-lg">Read More</a>
              </div>
            </li>
            <li>
              <div class="blog-card has-before has-after" data-reveal="bottom">
                <div class="meta-wrapper">
                  <div class="card-meta">
                    <ion-icon name="person-outline"></ion-icon>
                    <span class="span">By Admin</span>
                  </div>
                  <div class="card-meta">
                    <ion-icon name="folder-outline"></ion-icon>
                    <span class="span">Specialist</span>
                  </div>
                </div>
                <h3 class="headline-sm card-title">Empowering Young Minds: Fostering Autonomy in Children During the
                  Pandemic</h3>
                <time class="title-sm date" datetime="2022-01-28">Unveiling the Connections - 28 March, 2024</time>
                <p class="card-text">
                  In times of uncertainty, empowering children with a sense of control is pivotal. This article delves
                  into strategies for parents and caregivers to foster autonomy in children, ensuring their development
                  continues to flourish, even in challenging circumstances.
                </p>
                <a href="article2.html" class="btn-text title-lg">Read More</a>
              </div>
            </li>
            <li>
              <div class="blog-card has-before has-after" data-reveal="bottom">
                <div class="meta-wrapper">
                  <div class="card-meta">
                    <ion-icon name="person-outline"></ion-icon>
                    <span class="span">By Admin</span>
                  </div>
                  <div class="card-meta">
                    <ion-icon name="folder-outline"></ion-icon>
                    <span class="span">Specialist</span>
                  </div>
                </div>
                <h3 class="headline-sm card-title">Navigating the Risks: Binge Eating and Alcohol's Toll on Liver Health
                </h3>
                <time class="title-sm date" datetime="2022-01-28">Unveiling the Connections - 28 April, 2024</time>
                <p class="card-text">
                  In an era where indulgence is just around the corner, understanding the impact of overconsumption on
                  vital organs becomes crucial. This insightful article sheds light on how binge eating and excessive
                  drinking can lead to significant liver damage, exploring both the science behind it and ways to
                  mitigate risks.
                </p>
                <a href="article3.html" class="btn-text title-lg">Read More</a>
              </div>
            </li>
          </ul>
        </div>
      </section>
    </article>
  </main>
  <!-- 
    - #FOOTER
  -->
  <footer id="contact" class="footer" style="background-image: url('./assets/images/footer-bg.png')">
    <div class="container">
      <div class="section footer-top">
        <div class="footer-brand" data-reveal="bottom">
          <a href="#" class="logo">
            <img src="WhatsApp Image 2024-04-23 at 19.11.56_940cb2e8.jpg" width="206" height="56" loading="lazy" alt="CPC home">
          </a>
          <ul class="contact-list has-after">
            <li class="contact-item">
              <div class="item-icon">
                <ion-icon name="mail-open-outline"></ion-icon>
              </div>
              <div>
                <p>
                  Main Email : <a href="mailto:abdulaziz.alsayyed@lau.edu" class="contact-link">abdulaziz.alsayyed@&shy;lau.edu</a>
                </p>
                <p>
                  Inquiries : <a href="mailto:abd@mail.com" class="contact-link">abd@mail.com</a>
                </p>
              </div>
            </li>
            <li class="contact-item">
              <div class="item-icon">
                <ion-icon name="call-outline"></ion-icon>
              </div>
              <div>
                <p>
                  Office Telephone : <a href="tel:70738343" class="contact-link">70738343</a>
                </p>
                <p>
                  Mobile : <a href="tel:70738343" class="contact-link">70738343</a>
                </p>
              </div>
            </li>
          </ul>
        </div>
        <div class="footer-list" data-reveal="bottom">
          <p class="headline-sm footer-list-title">About Us</p>
          <p class="text">
            Embark on a journey with us where innovation meets expertise. At the heart of our mission lies a commitment
            to shaping a brighter future through exceptional service and relentless progress. Join us as we pave the way
            towards excellence.</p>
            <address class="address">
              <a href="https://www.google.com/maps/search/?api=1&query=758+Prosperity+Avenue+Dubai+Marina+Dubai+United+Arab+Emirates" target="_blank">
                <ion-icon name="map-outline"></ion-icon>
                <span class="text">
                  758 Prosperity Avenue<br>
                  Dubai Marina, Dubai<br>
                  United Arab Emirates
                </span>
              </a>
            </address>
            
        </div>
        <ul class="footer-list" data-reveal="bottom">
          <li>
            <p class="headline-sm footer-list-title">Services</p>
          </li>
          <li>
            <a href="#" class="text footer-link">Conditions</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Listing</a>
          </li>
          <li>
            <a href="#" class="text footer-link">How It Works</a>
          </li>
          <li>
            <a href="#" class="text footer-link">What We Offer</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Latest News</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Contact Us</a>
          </li>
        </ul>
        <ul class="footer-list" data-reveal="bottom">
          <li>
            <p class="headline-sm footer-list-title">Useful Links</p>
          </li>
          <li>
            <a href="#" class="text footer-link">Conditions</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Terms of Use</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Our Services</a>
          </li>
          <li>
            <a href="#" class="text footer-link">Join as a Doctor</a>
          </li>
          <li>
            <a href="#" class="text footer-link">New Guests List</a>
          </li>
          <li>
            <a href="#" class="text footer-link">The Team List</a>
          </li>
        </ul>
        <div class="footer-list" data-reveal="bottom">
          <p class="headline-sm footer-list-title">Subscribe</p>
          <form action="" class="footer-form">
            <input type="email" name="email" placeholder="Email" class="input-field title-lg">
            <button type="submit" class="btn has-before title-md">Subscribe</button>
            <p class="text">
              Get the latest updates via email. Any time you may unsubscribe
            </p>
          <p class="headline-sm footer-list-title">Chatbot:</p>
            <iframe
    allow="microphone;"
    width="350"
    height="430"
    src="https://console.dialogflow.com/api-client/demo/embedded/66d28b1a-ef11-4adb-b46f-dd2250eee9c5">
</iframe>
          </form>
          
        </div>
      </div>
      <div class="footer-bottom">
        <p class="text copyright">
          &copy; CPC 2024 | All Rights Reserved by Abdulaziz Al Sayyed
        </p>
        <ul class="social-list">
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-google"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-linkedin"></ion-icon>
            </a>
          </li>
          <li>
            <a href="#" class="social-link">
              <ion-icon name="logo-pinterest"></ion-icon>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <!-- 
    - #BACK TO TOP
  -->
  <a href="#top" class="back-top-btn" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up"></ion-icon>
  </a>
  <script src="./assets/js/script.js"></script>
  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>