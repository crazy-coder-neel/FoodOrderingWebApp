<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['add_to_cart'])) {
    $frankie_name = mysqli_real_escape_string($db, $_POST['frankie_name']);
    $frankie_price = floatval($_POST['frankie_price']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$frankie_name])) {
        $_SESSION['cart'][$frankie_name]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$frankie_name] = array(
            'price' => $frankie_price,
            'quantity' => 1
        );
    }
    header("Location: frankie.php");
    exit();
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Frankie Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --neon-orange: #ff5e00;
      --neon-cyan: #00f7ff;
      --neon-yellow: #ffee00;
      --neon-red: #ff003c;
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
      text-shadow: 0 0 10px var(--neon-cyan);
    }

    .header h1 {
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-orange);
      font-size: 3rem;
      animation: flicker 1.5s infinite alternate;
    }

    .frankie-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .frankie-card {
      background: var(--card-bg);
      border: 2px solid var(--neon-red);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 0 15px rgba(255, 0, 60, 0.3);
      position: relative;
    }

    .frankie-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px var(--neon-red);
      border-color: var(--neon-yellow);
    }

    .frankie-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid var(--neon-orange);
    }

    .frankie-info {
      padding: 20px;
    }

    .frankie-name {
      color: var(--neon-yellow);
      font-size: 1.5rem;
      margin-bottom: 10px;
      text-shadow: 0 0 5px var(--neon-yellow);
    }

    .frankie-desc {
      color: #ccc;
      margin-bottom: 15px;
    }

    .frankie-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: var(--neon-orange);
      font-size: 1.8rem;
      font-weight: bold;
      text-shadow: 0 0 5px var(--neon-orange);
    }

    .add-to-cart {
      background: transparent;
      border: 2px solid var(--neon-cyan);
      color: var(--neon-cyan);
      padding: 8px 20px;
      border-radius: 50px;
      font-family: 'Orbitron', sans-serif;
      cursor: pointer;
      transition: all 0.3s;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .add-to-cart:hover {
      background: var(--neon-cyan);
      color: var(--dark-bg);
      box-shadow: 0 0 15px var(--neon-cyan);
      text-shadow: none;
    }

    @keyframes flicker {
      0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% {
        text-shadow:
          0 0 5px var(--neon-orange),
          0 0 10px var(--neon-orange),
          0 0 20px var(--neon-orange),
          0 0 40px var(--neon-red);
      }
      20%, 24%, 55% {
        text-shadow: none;
      }
    }
    .frankie-card::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      border-radius: 15px;
      background: linear-gradient(45deg, 
        var(--neon-orange), 
        var(--neon-red), 
        var(--neon-yellow), 
        var(--neon-cyan));
      background-size: 400%;
      z-index: -1;
      opacity: 0;
      transition: 0.5s;
    }

    .frankie-card:hover::before {
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
    <h1>FRANKIES</h1>
    <p>Wrapped in digital flavor</p>
  </div>
  <div class="frankie-grid" id="frankie-container">
  </div>
  <script>
    const frankies = [
      {
        name: "Cheese Frankie",
        price: 120,
        img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4Xlh8esPVSAOwsmbDawCaEUCXZU4FtMVa_Q&s",
        desc: "Loaded with melted cheese, fresh veggies, and tangy mayo sauce in a soft wrap."
      },
      {
        name: "Peri Peri Frankie",
        price: 70,
        img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTYQB_x4Ghq671Rr4FOe5h3eCT6oFgyiv8SMg&s",
        desc: "Spicy peri peri tossed veggies with cheese and crunchy onions."
      },
      {
        name: "Paneer Tikka Frankie",
        price: 110,
        img: "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvX7zUCDmyK-SpYuh3oM0uiQUPdphrFJBkBQ&s",
        desc: "Grilled paneer cubes in tikka masala, onions, and mint chutney."
      },
      {
        name: "Masala Aloo Frankie",
        price: 125,
        img: "https://img-cdn.thepublive.com/fit-in/1200x675/filters:format(webp)/sanjeev-kapoor/media/media_files/QbofKFYyfHp2Dg06RrvL.JPG",
        desc: "Classic spiced potato filling, onions, chaat masala, and ketchup."
      },
      {
        name: "Schezwan Veg Frankie",
        price: 135,
        img: "https://i.ytimg.com/vi/9UlRvBhI398/sddefault.jpg",
        desc: "Stir-fried veggies tossed in spicy Schezwan sauce with a cheesy twist."
      },
      {
        name: "Chicken Tikka Frankie",
        price: 150,
        img: "https://media-assets.swiggy.com/swiggy/image/upload/f_auto,q_auto,fl_lossy/jwwgzdpk7dcq8yrvy1tc",
        desc: "Grilled chicken tikka, spicy chutney, and crunchy onions."
      },
      {
        name: "Peri Peri Chicken Frankie",
        price: 175,
        img: "https://i.pinimg.com/736x/e6/6c/3f/e66c3f5759ee96e38598cb9f0bd91821.jpg",
        desc: "Zesty peri peri marinated chicken with cheese and salad mix."
      },
      {
        name: "BBQ Chicken Frankie",
        price: 225,
        img: "https://www.indianhealthyrecipes.com/wp-content/uploads/2024/02/chicken-kathi-roll-chicken-frankie-480x270.jpg",
        desc: "Smoky BBQ chicken, sautéed onions, and creamy garlic sauce."
      },
      {
        name: "Egg & Cheese Frankie",
        price: 90,
        img: "https://recipesblob.oetker.in/assets/8209ead27fae402b974b847cd8b35b63/1272x764/paneer-frankie.webp",
        desc: "Soft egg omelette wrapped with cheese, onions, and tangy sauce."
      }
    ];
    const container = document.getElementById('frankie-container');
    frankies.forEach(frankie => {
      const card = document.createElement('div');
      card.className = 'frankie-card';
      card.innerHTML = `
        <img src="${frankie.img}" class="frankie-img" alt="${frankie.name}">
        <div class="frankie-info">
          <h3 class="frankie-name">${frankie.name}</h3>
          <p class="frankie-desc">${frankie.desc}</p>
          <div class="frankie-footer">
            <span class="price">₹${frankie.price.toFixed(2)}</span>
            <form method="post" style="display: inline;">
              <input type="hidden" name="frankie_name" value="${frankie.name}">
              <input type="hidden" name="frankie_price" value="${frankie.price}">
              <button type="submit" name="add_to_cart" class="add-to-cart">
                <i class="bi bi-cart-plus"></i> ORDER
              </button>
            </form>
          </div>
        </div>
      `;
      container.appendChild(card);
    });
  </script>
</body>
</html>
