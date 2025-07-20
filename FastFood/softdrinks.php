<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');
if (!$db) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['add_to_cart'])) {
  $drink_name = mysqli_real_escape_string($db, $_POST['drink_name']);
  $drink_price = floatval($_POST['drink_price']);
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }
  if (isset($_SESSION['cart'][$drink_name])) {
    $_SESSION['cart'][$drink_name]['quantity'] += 1;
  } else {
    $_SESSION['cart'][$drink_name] = array(
      'price' => $drink_price,
      'quantity' => 1
    );
  }
  header("Location: softdrinks.php");
  exit();
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Soft Drinks Menu</title>
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

    .drink-rows {
      display: flex;
      flex-direction: column;
      gap: 40px;
      padding: 20px;
      max-width: 1200px;
      margin: 0 auto;
    }

    .drink-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .drink-card {
      background: var(--card-bg);
      border: 2px solid var(--neon-purple);
      border-radius: 15px;
      overflow: hidden;
      transition: all 0.3s;
      box-shadow: 0 0 15px rgba(211, 0, 197, 0.3);
      position: relative;
    }

    .drink-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 25px var(--neon-purple);
      border-color: var(--neon-green);
    }

    .drink-img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 2px solid var(--neon-blue);
    }

    .drink-info {
      padding: 20px;
    }

    .drink-name {
      color: var(--neon-green);
      font-size: 1.5rem;
      margin-bottom: 10px;
      text-shadow: 0 0 5px var(--neon-green);
    }

    .drink-desc {
      color: #ccc;
      margin-bottom: 15px;
      font-size: 0.9rem;
      line-height: 1.4;
    }

    .drink-footer {
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
      font-size: 0.8rem;
    }

    .add-to-cart:hover {
      background: var(--neon-blue);
      color: var(--dark-bg);
      box-shadow: 0 0 15px var(--neon-blue);
      text-shadow: none;
    }

    @keyframes flicker {

      0%,
      19%,
      21%,
      23%,
      25%,
      54%,
      56%,
      100% {
        text-shadow:
          0 0 5px var(--neon-pink),
          0 0 10px var(--neon-pink),
          0 0 20px var(--neon-pink),
          0 0 40px var(--neon-blue);
      }

      20%,
      24%,
      55% {
        text-shadow: none;
      }
    }

    .drink-card::before {
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

    .drink-card:hover::before {
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
      .drink-row {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 600px) {
      .drink-row {
        grid-template-columns: 1fr;
      }

      .header h1 {
        font-size: 2rem;
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
    <h1>SOFT DRINKS</h1>
    <p>Fuel for the digital age</p>
  </div>

  <div class="drink-rows">
    <div class="drink-row" id="row1"></div>
    <div class="drink-row" id="row2"></div>
    <div class="drink-row" id="row3"></div>
  </div>

  <script>
    const drinks = [{
        name: "Coca-Cola",
        price: 75,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Coca-Cola-1024x576.jpg",
        desc: "Coca-Cola is one of the most popular cold drink brands in India."
      },
      {
        name: "Pepsi",
        price: 80,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Pepsi-1024x576.jpg",
        desc: "The brand is known for its refreshing taste and is a favourite among young people."
      },
      {
        name: "Sprite",
        price: 50,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Sprite-1024x576.jpg",
        desc: "Sprite is known for its refreshing taste and is a popular choice among people who prefer non-cola drinks."
      },
      {
        name: "Thums Up",
        price: 70,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Thums-Up-1024x576.jpg",
        desc: "Thums Up is a cola-flavoured drink and is known for its unique taste."
      },
      {
        name: "Fanta",
        price: 60,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/fanta-1024x576.jpg",
        desc: "Fanta is known for its refreshing taste and is available in various fruit flavours such as orange, grape, and pineapple."
      },
      {
        name: "Limca",
        price: 40,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Limca-1024x576.jpg",
        desc: "Limca is a popular lemon-lime-flavored coldrink brand in India."
      },
      {
        name: "7Up",
        price: 30,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/7up-1024x576.jpg",
        desc: "7Up is a popular lemon-lime-flavored cold drink brand in India."
      },
      {
        name: "Mountain Dew",
        price: 55,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Mountain-Dew-1024x576.jpg",
        desc: "Mountain Dew is a popular citrus-flavoured cold drink brand in India."
      },
      {
        name: "Mirinda",
        price: 75,
        img: "https://thekarostartup.com/wp-content/uploads/2024/01/Mirinda-1024x576.jpg",
        desc: "Mirinda is known for its refreshing taste and is available in various fruit flavours such as orange, grape, and apple."
      }
    ];
    const row1 = document.getElementById('row1');
    const row2 = document.getElementById('row2');
    const row3 = document.getElementById('row3');

    drinks.forEach((drink, index) => {
      const card = document.createElement('div');
      card.className = 'drink-card';
      card.innerHTML = `
        <img src="${drink.img}" class="drink-img" alt="${drink.name}">
        <div class="drink-info">
          <h3 class="drink-name">${drink.name}</h3>
          <p class="drink-desc">${drink.desc}</p>
          <div class="drink-footer">
            <span class="price">₹${drink.price.toFixed(2)}</span>
            <form method="post" style="display: inline;">
              <input type="hidden" name="drink_name" value="${drink.name}">
              <input type="hidden" name="drink_price" value="${drink.price}">
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