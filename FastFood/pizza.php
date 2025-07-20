<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['add_to_cart'])) {
    $pizza_name = mysqli_real_escape_string($db, $_POST['pizza_name']);
    $pizza_price = floatval($_POST['pizza_price']);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    if (isset($_SESSION['cart'][$pizza_name])) {
        $_SESSION['cart'][$pizza_name]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$pizza_name] = array(
            'price' => $pizza_price,
            'quantity' => 1
        );
    }
    header("Location: pizza.php");
    exit();
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pizza Menu</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <style>
    :root {
      --neon-red: #ff003c;
      --neon-orange: #ff5e00;
      --neon-yellow: #ffee00;
      --neon-blue: #05d9e8;
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
      color: var(--neon-red);
      font-size: 3rem;
      animation: flicker 1.5s infinite alternate;
    }

    .pizza-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    @media (max-width: 900px) {
      .pizza-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .pizza-grid {
        grid-template-columns: 1fr;
      }
    }

    .pizza-card {
      background: var(--card-bg);
      border: 2px solid var(--neon-orange);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 0 15px rgba(255, 94, 0, 0.3);
      position: relative;
    }

    .pizza-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px var(--neon-orange);
      border-color: var(--neon-yellow);
    }

    .pizza-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid var(--neon-red);
    }

    .pizza-info {
      padding: 20px;
    }

    .pizza-name {
      color: var(--neon-yellow);
      font-size: 1.5rem;
      margin-bottom: 10px;
      text-shadow: 0 0 5px var(--neon-yellow);
    }

    .pizza-desc {
      color: #ccc;
      margin-bottom: 15px;
    }

    .pizza-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .price {
      color: var(--neon-red);
      font-size: 1.8rem;
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
          0 0 5px var(--neon-red),
          0 0 10px var(--neon-red),
          0 0 20px var(--neon-red),
          0 0 40px var(--neon-orange);
      }
      20%, 24%, 55% {
        text-shadow: none;
      }
    }
    .pizza-card::before {
      content: '';
      position: absolute;
      top: -2px;
      left: -2px;
      right: -2px;
      bottom: -2px;
      border-radius: 15px;
      background: linear-gradient(45deg, 
        var(--neon-red), 
        var(--neon-orange), 
        var(--neon-yellow), 
        var(--neon-blue));
      background-size: 400%;
      z-index: -1;
      opacity: 0;
      transition: 0.5s;
    }

    .pizza-card:hover::before {
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
    @keyframes fadeOut {
      0% { opacity: 1; transform: translateY(0); }
      70% { opacity: 1; transform: translateY(0); }
      100% { opacity: 0; transform: translateY(20px); }
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
    <h1>CRUSTY PIZZAS</h1>
    <p>Fuel for the digital age</p>
  </div>
  <div class="pizza-grid" id="pizza-container">
  </div>
  <script>
    const pizzas = [
      {
        name: "Pizzeria da Attilio",
        price: 425,
        img: "https://media.timeout.com/images/106247671/1024/576/image.webp",
        desc: "Classic Pizza Margherita, the queen of all pizzas."
      },
      {
        name: "Pizza Marumo",
        price: 190,
        img: "https://media.timeout.com/images/106248077/1024/576/image.webp",
        desc: "Standout pizzeria driving Tokyo's flourishing pizza scene."
      },
      {
        name: "Bella Brutta",
        price: 225,
        img: "https://media.timeout.com/images/105308244/1024/576/image.webp",
        desc: "Banging clam pizza with a taste of the sea."
      },
      {
        name: "Diamond Slice",
        price: 575,
        img: "https://media.timeout.com/images/106204648/1024/576/image.webp",
        desc: "Copenhagen's hyped pizzeria of the moment."
      },
      {
        name: "Dough Hands",
        price: 350,
        img: "https://media.timeout.com/images/106233086/1024/576/image.webp",
        desc: "London Fields' most sought-after pizza."
      },
      {
        name: "Novo",
        price: 210,
        img: "https://media.timeout.com/images/106201774/1024/576/image.webp",
        desc: "Family-owned place with loyal following."
      },
      {
        name: "Oobatz",
        price: 349,
        img: "https://media.timeout.com/images/106141962/1024/576/image.webp",
        desc: "Minimalist spot with exceptional pies."
      },
      {
        name: "Baldoria",
        price: 249,
        img: "https://media.timeout.com/images/106201776/1024/576/image.webp",
        desc: "Italian ristorante with inspired flavors."
      },
      {
        name: "Milly's Pizza",
        price: 285,
        img: "https://media.timeout.com/images/106244747/1024/576/image.webp",
        desc: "Zesty pepperoni with fresh mozzarella."
      }
    ];
    const container = document.getElementById('pizza-container');
    pizzas.forEach(pizza => {
      const card = document.createElement('div');
      card.className = 'pizza-card';
      card.innerHTML = `
        <img src="${pizza.img}" class="pizza-img" alt="${pizza.name}">
        <div class="pizza-info">
          <h3 class="pizza-name">${pizza.name}</h3>
          <p class="pizza-desc">${pizza.desc}</p>
          <div class="pizza-footer">
            <span class="price">₹${pizza.price.toFixed(2)}</span>
            <form method="post" style="display: inline;">
              <input type="hidden" name="pizza_name" value="${pizza.name}">
              <input type="hidden" name="pizza_price" value="${pizza.price}">
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