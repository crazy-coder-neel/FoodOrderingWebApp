<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $burger_name => $quantity) {
        $burger_name = mysqli_real_escape_string($db, $burger_name);
        $quantity = intval($quantity);
        
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$burger_name]);
        } else {
            $_SESSION['cart'][$burger_name]['quantity'] = $quantity;
        }
    }
    header("Location: cart.php");
    exit();
}

if (isset($_GET['remove'])) {
    $burger_name = mysqli_real_escape_string($db, $_GET['remove']);
    if (isset($_SESSION['cart'][$burger_name])) {
        unset($_SESSION['cart'][$burger_name]);
    }
    header("Location: cart.php");
    exit();
}

if (isset($_POST['checkout'])) {
    if (!empty($_SESSION['cart'])) {
        $order_total = 0;
        foreach ($_SESSION['cart'] as $burger_name => $item) {
            $order_total += $item['price'] * $item['quantity'];
        }
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; 
        $order_date = date('Y-m-d H:i:s');
        $insert_order = "INSERT INTO orders (user_id, order_date, total_amount, status) VALUES ('$user_id', '$order_date', '$order_total', 'pending')";
        if (mysqli_query($db, $insert_order)) {
            $order_id = mysqli_insert_id($db);
            foreach ($_SESSION['cart'] as $burger_name => $item) {
                $burger_name = mysqli_real_escape_string($db, $burger_name);
                $price = floatval($item['price']);
                $quantity = intval($item['quantity']);
                
                $insert_item = "INSERT INTO order_items (order_id, burger_name, price, quantity) VALUES ('$order_id', '$burger_name', '$price', '$quantity')";
                mysqli_query($db, $insert_item);
            }
            header("Location: checkout.php?order_id=$order_id");
            exit();
        } else {
            $error = "Error placing order: " . mysqli_error($db);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Cart</title>
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

    .cart-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .cart-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    .cart-table th {
      text-align: left;
      padding: 15px;
      background-color: var(--card-bg);
      color: var(--neon-green);
      border-bottom: 2px solid var(--neon-purple);
    }

    .cart-table td {
      padding: 15px;
      border-bottom: 1px solid var(--neon-blue);
    }

    .cart-table tr:hover {
      background-color: rgba(90, 24, 154, 0.1);
    }

    .quantity-input {
      width: 60px;
      padding: 8px;
      background: transparent;
      border: 1px solid var(--neon-blue);
      color: white;
      text-align: center;
    }

    .remove-btn {
      color: var(--neon-pink);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 1.2rem;
    }

    .cart-total {
      text-align: right;
      font-size: 1.5rem;
      margin: 20px 0;
    }

    .cart-total span {
      color: var(--neon-green);
      text-shadow: 0 0 5px var(--neon-green);
    }

    .cart-actions {
      display: flex;
      justify-content: space-between;
    }

    .cart-btn {
      padding: 12px 25px;
      border-radius: 50px;
      font-family: 'Orbitron', sans-serif;
      cursor: pointer;
      transition: all 0.3s;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: bold;
    }

    .continue-shopping {
      background: transparent;
      border: 2px solid var(--neon-blue);
      color: var(--neon-blue);
    }

    .continue-shopping:hover {
      background: var(--neon-blue);
      color: var(--dark-bg);
      box-shadow: 0 0 15px var(--neon-blue);
    }

    .checkout-btn {
      background: var(--neon-pink);
      border: 2px solid var(--neon-pink);
      color: white;
    }

    .checkout-btn:hover {
      background: transparent;
      color: var(--neon-pink);
      box-shadow: 0 0 15px var(--neon-pink);
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

    .empty-cart {
      text-align: center;
      margin: 50px 0;
      color: var(--neon-blue);
      font-size: 1.5rem;
    }

    .empty-cart i {
      font-size: 3rem;
      display: block;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>YOUR CART</h1>
    <p>Ready to fuel up?</p>
  </div>

  <div class="cart-container">
    <?php if (!empty($_SESSION['cart'])): ?>
      <form method="post">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Item</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $cart_total = 0;
              foreach ($_SESSION['cart'] as $burger_name => $item): 
                $item_total = $item['price'] * $item['quantity'];
                $cart_total += $item_total;
            ?>
              <tr>
                <td><?php echo htmlspecialchars($burger_name); ?></td>
                <td>₹<?php echo number_format($item['price'], 2); ?></td>
                <td>
                  <input type="number" name="quantity[<?php echo htmlspecialchars($burger_name); ?>]" 
                         value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                </td>
                <td>₹<?php echo number_format($item_total, 2); ?></td>
                <td>
                  <a href="cart.php?remove=<?php echo urlencode($burger_name); ?>" class="remove-btn">
                    <i class="bi bi-trash-fill"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        
        <div class="cart-total">
          Total: ₹<?php echo number_format($cart_total, 2); ?>
        </div>
        
        <div class="cart-actions">
          <a href="index.php" class="cart-btn continue-shopping">
            <i class="bi bi-arrow-left"></i> Continue Shopping
          </a>
          <div>
            <button type="submit" name="update_cart" class="cart-btn update-cart-btn">
              Update Cart
            </button>
            <button type="submit" name="checkout" class="cart-btn checkout-btn">
              Checkout <i class="bi bi-credit-card"></i>
            </button>
          </div>
        </div>
      </form>
    <?php else: ?>
      <div class="empty-cart">
        <i class="bi bi-cart-x"></i>
        <p>Your cart is empty!</p>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>


