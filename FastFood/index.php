<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NXT CAPITAL DELIGHT</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --neon-red: #ff003c;
      --neon-orange: #ff5e00;
      --neon-yellow: #ffee00;
      --neon-blue: #05d9e8;
      --neon-green: #00ff9d;
      --neon-purple: #d300c5;
      --dark-bg: #0d0221;
      --card-bg: #1a1a2e;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background-color: var(--dark-bg);
      color: white;
      font-family: 'Orbitron', sans-serif;
      overflow-x: hidden;
      min-height: 100vh;
      background-image: 
        radial-gradient(circle at 10% 20%, rgba(255, 0, 60, 0.05) 0%, transparent 20%),
        radial-gradient(circle at 90% 80%, rgba(5, 217, 232, 0.05) 0%, transparent 20%);
    }
    
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px 5%;
      background-color: rgba(13, 2, 33, 0.9);
      border-bottom: 1px solid var(--neon-blue);
      position: sticky;
      top: 0;
      z-index: 100;
      backdrop-filter: blur(5px);
    }

    .logo {
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-red);
      font-size: 1.5rem;
      text-shadow: 0 0 5px var(--neon-red);
      animation: flicker 3s infinite alternate;
    }

    .nav-links {
      display: flex;
      gap: 30px;
    }

    .nav-links a {
      color: var(--neon-blue);
      text-decoration: none;
      font-weight: bold;
      letter-spacing: 1px;
      position: relative;
      padding: 5px 0;
      transition: all 0.3s;
    }

    .nav-links a:hover {
      color: var(--neon-green);
      text-shadow: 0 0 5px var(--neon-green);
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--neon-blue);
      transition: width 0.3s;
    }

    .nav-links a:hover::after {
      width: 100%;
      background: var(--neon-green);
    }

    .cart-icon {
      color: var(--neon-yellow);
      font-size: 1.5rem;
      cursor: pointer;
      transition: all 0.3s;
    }

    .cart-icon:hover {
      transform: scale(1.2);
      text-shadow: 0 0 10px var(--neon-yellow);
    }
    
    section {
      min-height: 100vh;
      padding: 80px 5%;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    #home {
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .hero h1 {
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-red);
      font-size: 4rem;
      margin-bottom: 30px;
      text-shadow: 0 0 10px var(--neon-red);
      animation: flicker 1.5s infinite alternate;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 800px;
      margin: 0 auto 40px;
      line-height: 1.6;
      color: var(--neon-blue);
    }

    .cta-button {
      background: transparent;
      border: 2px solid var(--neon-green);
      color: var(--neon-green);
      padding: 12px 30px;
      border-radius: 50px;
      font-family: 'Orbitron', sans-serif;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s;
      text-transform: uppercase;
      letter-spacing: 2px;
      margin: 0 10px;
    }

    .cta-button:hover {
      background: var(--neon-green);
      color: var(--dark-bg);
      box-shadow: 0 0 20px var(--neon-green);
      transform: translateY(-3px);
    }

    .secondary-button {
      border-color: var(--neon-purple);
      color: var(--neon-purple);
    }

    .secondary-button:hover {
      background: var(--neon-purple);
      box-shadow: 0 0 20px var(--neon-purple);
    }
    
    #products {
      background-color: rgba(26, 26, 46, 0.3);
    }

    .section-title {
      text-align: center;
      margin-bottom: 60px;
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-blue);
      font-size: 2.5rem;
      text-shadow: 0 0 10px var(--neon-blue);
    }

    .products-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      max-width: 1500px;
      margin: 0 auto;
    }

    .product-card {
      background: var(--card-bg);
      border: 2px solid var(--neon-purple);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 0 15px rgba(211, 0, 197, 0.3);
      position: relative;
    }

    .product-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px var(--neon-purple);
      border-color: var(--neon-green);
    }

    .product-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid var(--neon-blue);
    }

    .product-info {
      padding: 20px;
    }

    .product-name {
      color: var(--neon-green);
      font-size: 1.5rem;
      margin-bottom: 10px;
      text-shadow: 0 0 5px var(--neon-green);
    }

    .product-desc {
      color: #ccc;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .product-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: var(--neon-red);
      font-size: 1.5rem;
      font-weight: bold;
      text-shadow: 0 0 5px var(--neon-red);
    }

    .add-to-cart {
      background: transparent;
      border: 2px solid var(--neon-blue);
      color: var(--neon-blue);
      padding: 8px 20px;
      border-radius: 50px;
      font-family: 'Orbitron', sans-serif;
      cursor: pointer;
      transition: all 0.3s;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.8rem;
    }

    .add-to-cart:hover {
      background: var(--neon-blue);
      color: var(--dark-bg);
      box-shadow: 0 0 15px var(--neon-blue);
      text-shadow: none;
    }

    .product-card::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      border-radius: 15px;
      background: linear-gradient(45deg, 
        var(--neon-blue), 
        var(--neon-purple), 
        var(--neon-red), 
        var(--neon-green));
      background-size: 400%;
      z-index: -1;
      opacity: 0;
      transition: 0.5s;
    }

    .product-card:hover::before {
      opacity: 1;
      animation: animate 8s linear infinite;
    }
    
    #faq {
      background-color: rgba(13, 2, 33, 0.7);
    }

    .faq-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .faq-item {
      margin-bottom: 20px;
      border: 1px solid var(--neon-blue);
      border-radius: 10px;
      overflow: hidden;
      transition: all 0.3s;
    }

    .faq-item:hover {
      border-color: var(--neon-green);
      box-shadow: 0 0 15px rgba(0, 255, 157, 0.2);
    }

    .faq-question {
      padding: 20px;
      background-color: rgba(26, 26, 46, 0.5);
      color: var(--neon-blue);
      cursor: pointer;
      font-weight: bold;
      display: flex;
      justify-content: space-between;
      align-items: center;
      transition: all 0.3s;
    }

    .faq-question:hover {
      color: var(--neon-green);
      background-color: rgba(26, 26, 46, 0.7);
    }

    .faq-answer {
      padding: 0 20px;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.3s ease-out;
      background-color: rgba(26, 26, 46, 0.3);
    }

    .faq-item.active .faq-answer {
      padding: 20px;
      max-height: 300px;
    }

    .faq-toggle {
      font-size: 1.2rem;
      transition: transform 0.3s;
    }

    .faq-item.active .faq-toggle {
      transform: rotate(45deg);
    }

    footer {
      text-align: center;
      padding: 30px 5%;
      background-color: rgba(13, 2, 33, 0.9);
      border-top: 1px solid var(--neon-purple);
    }

    .social-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 20px;
    }

    .social-links a {
      color: var(--neon-blue);
      font-size: 1.5rem;
      transition: all 0.3s;
    }

    .social-links a:hover {
      color: var(--neon-green);
      transform: translateY(-3px);
      text-shadow: 0 0 10px var(--neon-green);
    }

    .copyright {
      color: var(--neon-blue);
      font-size: 0.9rem;
    }

    @keyframes flicker {
      0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
        text-shadow:
          0 0 5px var(--neon-red),
          0 0 10px var(--neon-red),
          0 0 20px var(--neon-red),
          0 0 40px var(--neon-blue);
      }
      20%, 24%, 55% {
        text-shadow: none;
      }
    }

    @keyframes animate {
      0% {
        background-position: 0 0;
      }
      50% {
        background-position: 400% 0;
      }
      100% {
        background-position: 0 0;
      }
    }
    
    .notification {
      position: fixed;
      bottom: 20px;
      right: 20px;
      padding: 15px 25px;
      background: rgba(5, 217, 232, 0.2);
      border: 1px solid var(--neon-blue);
      border-radius: 5px;
      color: var(--neon-blue);
      font-weight: bold;
      text-shadow: 0 0 5px var(--neon-blue);
      box-shadow: 0 0 15px var(--neon-blue);
      z-index: 1000;
      animation: fadeOut 3s forwards;
      display: none;
    }

    @keyframes fadeOut {
      0% { opacity: 1; transform: translateY(0); }
      70% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(20px); }
    }
    
    .active-nav {
      color: var(--neon-green) !important;
      text-shadow: 0 0 5px var(--neon-green) !important;
    }

    .active-nav::after {
      width: 100% !important;
      background: var(--neon-green) !important;
    }
    
    .menu-toggle {
      display: none;
      cursor: pointer;
      font-size: 1.5rem;
      color: var(--neon-blue);
    }
    
    @media (max-width: 992px) {
      .hero h1 {
        font-size: 3rem;
      }
      
      .section-title {
        font-size: 2rem;
      }
    }
    
    @media (max-width: 768px) {
      nav {
        flex-wrap: wrap;
      }
      
      .menu-toggle {
        display: block;
        order: 1;
      }
      
      .logo {
        order: 2;
        font-size: 1.2rem;
        margin-right: auto;
        padding-left: 15px;
      }
      
      .nav-links {
        display: none;
        width: 100%;
        order: 3;
        flex-direction: column;
        gap: 15px;
        padding: 20px 0;
      }
      
      .nav-links.active {
        display: flex;
      }
      
      .hero h1 {
        font-size: 2.5rem;
        margin-bottom: 20px;
      }
      
      .hero p {
        font-size: 1rem;
        padding: 0 15px;
      }
      
      .cta-button {
        padding: 10px 20px;
        font-size: 1rem;
        margin: 5px;
      }
      
      .section-title {
        font-size: 1.8rem;
        margin-bottom: 40px;
      }
      
      .products-grid {
        grid-template-columns: 1fr;
        gap: 20px;
      }
      
      .faq-question {
        padding: 15px;
      }
    }
    
    @media (max-width: 480px) {
      .hero h1 {
        font-size: 2rem;
      }
      
      .hero p {
        font-size: 0.9rem;
      }
      
      .hero-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
      }
      
      .cta-button {
        width: 100%;
        margin: 5px 0;
      }
      
      .section-title {
        font-size: 1.5rem;
      }
      
      footer {
        padding: 20px 5%;
      }
      
      .social-links {
        gap: 15px;
      }
      
      .copyright {
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <nav>
    <div class="menu-toggle">
      <i class="bi bi-list"></i>
    </div>
    <div class="logo">NXT CAPITAL DELIGHT</div>
    <div class="nav-links">
      <a href="#home" class="active-nav">HOME</a>
      <a href="#products">PRODUCTS</a>
      <a href="#faq">FAQ</a>
      <a href="cart.php" id="cart-link">CART <i class="bi bi-cart"></i></a>
    </div>
  </nav>
  
  <section id="home">
    <div class="hero">
      <h1>NXT CAPITAL DELIGHT</h1>
      <p>Experience the future of fast food with our mouthwatering creations crafted to satisfy every craving. Our kitchen blends bold flavors and fresh ingredients to deliver a delicious journey you won't forget.</p>
      <div class="hero-buttons">
        <a href="#products"><button class="cta-button">ORDER NOW</button></a>
        <a href="#products"><button class="cta-button secondary-button">VIEW MENU</button></a>
      </div>
    </div>
  </section>
  
  <section id="products">
    <h2 class="section-title">OUR DELICACIES</h2>
    <div class="products-grid">
      <a href="burger.php" style="text-decoration: none;">
        <div class="product-card">
          <img src="burger.jpg" class="product-img" alt="Neon Burger">
          <div class="product-info">
            <h3 class="product-name">BURGER</h3>
            <p class="product-desc">Double patty with sauce and glowing cheese that actually pulses with light. Contains nano-enhanced flavor boosters.</p>
          </div>
        </div>
      </a>
      <a href="pizza.php" style="text-decoration: none;">
        <div class="product-card">
          <img src="pizza.jpg" class="product-img" alt="Pizza">
          <div class="product-info">
            <h3 class="product-name">PIZZA</h3>
            <p class="product-desc">Glowing crust with holographic toppings that change flavor as you eat. Powered by quantum cheese technology.</p>
          </div>
        </div>
      </a>
      <a href="frankie.php" style="text-decoration: none;">
        <div class="product-card">
          <img src="frankie.jpg" class="product-img" alt="Frankie">
          <div class="product-info">
            <h3 class="product-name">FRANKIE</h3>
            <p class="product-desc">Wrap that breaches your taste firewalls. Contains encrypted flavors that unlock as you eat. Comes with digital dipping sauce.</p>
          </div>
        </div>
      </a>
      <a href="softdrinks.php" style="text-decoration: none;">
        <div class="product-card">
          <img src="softdrinks.png" class="product-img" alt="SoftDrink">
          <div class="product-info">
            <h3 class="product-name">SOFT DRINKS</h3>
            <p class="product-desc">Liquid that exists in multiple flavor states simultaneously. Collapses to your preferred taste upon observation (drinking).</p>
          </div>
        </div>
      </a>
    </div>
  </section>
  
  <section id="faq">
    <h2 class="section-title">FAQ</h2>
    <div class="faq-container">
      <div class="faq-item">
        <div class="faq-question">
          <span>1. What makes NXT CAPITAL DELIGHT different from other fast food places?</span>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          <p>At NXT CAPITAL DELIGHT, we blend bold flavors with futuristic vibes! From innovative recipes to lightning-fast service, we're all about serving delicious food with a next-gen twist.</p>
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          <span>2. Do you offer vegetarian or vegan options?</span>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          <p>Yes! We have a variety of vegetarian and vegan options crafted with care - from plant-based burgers to guilt-free sides. Look for the green leaf icon on our menu!</p>
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          <span>3. Can I order online or for delivery?</span>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          <p>Absolutely! You can order directly through our website. We also partner with popular delivery platforms for a hassle-free experience right at your doorstep.</p>
        </div>
      </div>
      <div class="faq-item">
        <div class="faq-question">
          <span>4. Is your food freshly prepared?</span>
          <span class="faq-toggle">+</span>
        </div>
        <div class="faq-answer">
          <p>Always! Our ingredients are freshly sourced and every order is made with care and speed to deliver maximum freshness and taste. No shortcuts - just real, delicious food.</p>
        </div>
      </div>
    </div>
  </section>
  
  <footer>
    <div class="social-links">
      <a href="#"><i class="bi bi-twitter"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
      <a href="#"><i class="bi bi-tiktok"></i></a>
      <a href="#"><i class="bi bi-discord"></i></a>
    </div>
    <p class="copyright">© 2025 NXT CAPITAL DELIGHT | All digital rights reserved in virtual realms</p>
  </footer>
  
  <div class="notification" id="notification"></div>

  <script>
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
    });
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
      });
    });

    const faqItems = document.querySelectorAll('.faq-item');
    faqItems.forEach(item => {
      const question = item.querySelector('.faq-question');
      question.addEventListener('click', () => {
        item.classList.toggle('active');
      });
    });

    window.addEventListener('scroll', () => {
      const scrollPosition = window.scrollY;
      
      document.querySelectorAll('section').forEach(section => {
        const sectionTop = section.offsetTop - 100;
        const sectionHeight = section.offsetHeight;
        const sectionId = section.getAttribute('id');
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
          document.querySelectorAll('.nav-links a').forEach(link => {
            link.classList.remove('active-nav');
            if (link.getAttribute('href') === `#${sectionId}`) {
              link.classList.add('active-nav');
            }
          });
        }
      });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80,
            behavior: 'smooth'
          });
        }
      });
    });
  </script>
</body>
</html>