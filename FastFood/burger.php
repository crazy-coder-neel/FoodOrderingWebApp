<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');

if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['add_to_cart'])) {
    $burger_name = mysqli_real_escape_string($db, $_POST['burger_name']);
    $burger_price = floatval($_POST['burger_price']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$burger_name])) {
        $_SESSION['cart'][$burger_name]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$burger_name] = array(
            'price' => $burger_price,
            'quantity' => 1
        );
    }
    header("Location: burger.php");
    exit();
}
?>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Burger Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --neon-pink: #ff2a6d;
      --neon-blue: #05d9e8;
      --neon-purple: #d300c5;
      --neon-green: #00ff9d;
      --dark-bg: #0d0221;
      --card-bg: #1a1a2e;
    }

    body {
      background-color: var(--dark-bg);
      color: white;
      font-family: 'Orbitron', sans-serif;
      overflow-x: hidden;
    }

    .header {
      text-align: center;
      margin: 40px 0;
      text-shadow: 0 0 10px var(--neon-blue);
    }

    .header h1 {
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-pink);
      font-size: 3rem;
      animation: flicker 1.5s infinite alternate;
    }

    .burger-rows {
      display: flex;
      flex-direction: column;
      gap: 40px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .burger-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .burger-card {
      background: var(--card-bg);
      border: 2px solid var(--neon-purple);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 0 15px rgba(211, 0, 197, 0.3);
      position: relative;
    }

    .burger-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px var(--neon-purple);
      border-color: var(--neon-green);
    }

    .burger-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid var(--neon-blue);
    }

    .burger-info {
      padding: 20px;
    }

    .burger-name {
      color: var(--neon-green);
      font-size: 1.5rem;
      margin-bottom: 10px;
      text-shadow: 0 0 5px var(--neon-green);
    }

    .burger-desc {
      color: #ccc;
      margin-bottom: 15px;
    }

    .burger-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: var(--neon-pink);
      font-size: 1.8rem;
      font-weight: bold;
      text-shadow: 0 0 5px var(--neon-pink);
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
    }

    .add-to-cart:hover {
      background: var(--neon-blue);
      color: var(--dark-bg);
      box-shadow: 0 0 15px var(--neon-blue);
      text-shadow: none;
    } 
    @keyframes flicker {
      0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
        text-shadow:
          0 0 5px var(--neon-pink),
          0 0 10px var(--neon-pink),
          0 0 20px var(--neon-pink),
          0 0 40px var(--neon-blue);
      }
      20%, 24%, 55% {
        text-shadow: none;
      }
    }
    .burger-card::before {
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
        var(--neon-pink), 
        var(--neon-green));
      background-size: 400%;
      z-index: -1;
      opacity: 0;
      transition: 0.5s;
    }

    .burger-card:hover::before {
      opacity: 1;
      animation: animate 8s linear infinite;
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
    @media (max-width: 900px) {
      .burger-row {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .burger-row {
        grid-template-columns: 1fr;
      }
    }
    .cart-icon {
      position: fixed;
      top: 20px;
      right: 20px;
      font-size: 1.5rem;
      color: var(--neon-green);
      cursor: pointer;
      z-index: 1000;
      text-shadow: 0 0 5px var(--neon-green);
    }
    
    .cart-count {
      position: absolute;
      top: -10px;
      right: -10px;
      background: var(--neon-pink);
      color: white;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.8rem;
    }
  </style>
</head>
<body>
  <a href="cart.php" class="cart-icon">
    <i class="bi bi-cart-fill"></i>
    <span class="cart-count">
      <?php 
        echo isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
      ?>
    </span>
  </a>
  <div class="header">
    <h1>BURGERS</h1>
    <p>Fuel for the digital age</p>
  </div>

  <div class="burger-rows">
    <div class="burger-row" id="row1">
    </div>
  
    <div class="burger-row" id="row2">
    </div>
    
    <div class="burger-row" id="row3">
    </div>
  </div>

  <script>
    const burgers = [
      {
        name: "Beefy Bliss",
        price: 125,
        img: "https://images.unsplash.com/photo-1568901346375-23c9450c58cd",
        desc: "Juicy beef patty, cheddar cheese, lettuce, tomato, onions, and house sauce."
      },
      {
        name: "Smoky Stack",
        price: 150,
        img: "https://images.unsplash.com/photo-1553979459-d2229ba7433b",
        desc: "Smoked chicken patty, BBQ sauce, pickles, and crispy onions"
      },
      {
        name: "Paneer Supreme",
        price: 75,
        img: "https://images.unsplash.com/photo-1603064752734-4c48eff53d05",
        desc: "Spiced paneer patty, cheese slice, onion rings, and tangy sauce."
      },
      {
        name: "Mushroom Magic",
        price: 90,
        img: "https://images.unsplash.com/photo-1512152272829-e3139592d56f",
        desc: "Grilled mushrooms, swiss cheese, and garlic aioli on a soft bun."
      },
      {
        name: "Peri Peri Punch",
        price: 135,
        img: "https://images.unsplash.com/photo-1586190848861-99aa4a171e90",
        desc: "Peri peri paneer patty, lettuce, onion, and spicy mayo."
      },
      {
        name: "Midnight Patty",
        price: 150,
        img: "https://images.unsplash.com/photo-1525351326368-efbb5cb6814d",
        desc: "Black bun, grilled patty, bacon (optional), cheese, and smoky chipotle sauce."
      },
      {
        name: "Cheesy Volcano",
        price: 165,
        img: "https://images.unsplash.com/photo-1565299507177-b0ac66763828",
        desc: "Double cheese, grilled onions, and creamy jalapeño sauce."
      },
      {
        name: "Firecracker Burger",
        price: 199,
        img: "https://images.unsplash.com/photo-1561758033-d89a9ad46330",
        desc: "Spicy chicken patty, jalapeños, hot sauce, and pepper jack cheese."
      },
      {
        name: "The Green Crunch",
        price: 99,
        img: "https://images.unsplash.com/photo-1551782450-a2132b4ba21d",
        desc: "Crispy veggie patty, lettuce, tomato, cucumber, and mint mayo."
      }
    ];
    const row1 = document.getElementById('row1');
    const row2 = document.getElementById('row2');
    const row3 = document.getElementById('row3');
    
    burgers.forEach((burger, index) => {
      const card = document.createElement('div');
      card.className = 'burger-card';
      card.innerHTML = `
        <img src="${burger.img}" class="burger-img" alt="${burger.name}">
        <div class="burger-info">
          <h3 class="burger-name">${burger.name}</h3>
          <p class="burger-desc">${burger.desc}</p>
          <div class="burger-footer">
            <span class="price">₹${burger.price.toFixed(2)}</span>
            <form method="post" style="display: inline;">
              <input type="hidden" name="burger_name" value="${burger.name}">
              <input type="hidden" name="burger_price" value="${burger.price}">
              <button type="submit" name="add_to_cart" class="add-to-cart">
                <i class="bi bi-cart-plus"></i> ORDER
              </button>
            </form>
          </div>
        </div>
      `;
      
      if (index < 3) {
        row1.appendChild(card);
      } else if (index < 6) {
        row2.appendChild(card);
      } else {
        row3.appendChild(card);
      }
    });
  </script>
</body>
</html>