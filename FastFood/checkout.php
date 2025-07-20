<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$db = mysqli_connect('localhost', 'root', '', 'YOUR_PASSWORD');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}
$cart_total = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
    }
}

if (isset($_POST['generate_invoice'])) {
    if (!empty($_SESSION['cart'])) {
        require('libs/fpdf.php'); 
        class PDF extends FPDF {
            function Header() {
                $this->SetFont('Arial', 'B', 20);
                $this->Cell(0, 10, 'NXT CAPITAL DELIGHT', 0, 1, 'C');
                $this->SetFont('Arial', '', 12);
                $this->Cell(0, 10, 'NXT CAPITAL DELIGHT - Invoice', 0, 1, 'C');
                $this->Ln(5);
            }
            function Footer() {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 9);
                $this->Cell(0, 10, 'Thank you for choosing NXT CAPITAL DELIGHT !', 0, 0, 'C');
            }
        }
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 11);
        $pdf->Cell(100, 8, 'Date: ' . date('Y-m-d H:i:s'), 0, 0);
        $pdf->Cell(0, 8, 'Invoice #: ' . rand(1000,9999), 0, 1);
        $pdf->Cell(100, 8, 'Customer: ' . (isset($_SESSION['user_id']) ? 'User #' . $_SESSION['user_id'] : 'Guest'), 0, 0);
        $pdf->Cell(0, 8, 'Website: nxtcapitaldelight.com', 0, 1);
        $pdf->Ln(6);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(230, 230, 230);
        $pdf->Cell(100, 10, 'Item', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Quantity', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Unit Price', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);
        $pdf->SetFont('Arial', '', 11);
        $order_total = 0;
        foreach ($_SESSION['cart'] as $burger_name => $item) {
            $line_total = $item['price'] * $item['quantity'];
            $order_total += $line_total;

            $pdf->Cell(100, 10, substr($burger_name, 0, 40), 1);
            $pdf->Cell(30, 10, $item['quantity'], 1, 0, 'C');
            $pdf->Cell(30, 10, "Rs." . number_format($item['price'], 2), 1, 0, 'C');
            $pdf->Cell(30, 10, "Rs." . number_format($line_total, 2), 1, 1, 'C');
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(160, 10, 'Subtotal', 1);
        $pdf->Cell(30, 10, "Rs." . number_format($order_total, 2), 1, 1, 'C');
        $tax = $order_total * 0.05;
        $grand_total = $order_total + $tax;
        $pdf->Cell(160, 10, 'Tax (5%)', 1);
        $pdf->Cell(30, 10, "Rs." . number_format($tax, 2), 1, 1, 'C');
        $pdf->Cell(160, 10, 'Grand Total', 1);
        $pdf->Cell(30, 10, "Rs." . number_format($grand_total, 2), 1, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->MultiCell(0, 6, "We hope you enjoy your meal!\nFor support, contact support@nxtcapitaldelight.com", 0, 'C');
        $filename = "NXT_CAPITAL_DELIGHT_INVOICE_" . date('Ymd_His') . ".pdf";
        $pdf->Output('D',$filename);
        exit();
    } else {
        header("Location: checkout.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
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
      margin: 0;
      padding: 0;
    }

    .header {
      text-align: center;
      margin: 30px 0;
      text-shadow: 0 0 10px var(--neon-blue);
    }

    .header h1 {
      font-family: 'Press Start 2P', cursive;
      color: var(--neon-pink);
      font-size: 2.5rem;
      animation: flicker 1.5s infinite alternate;
    }

    .checkout-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    .payment-methods {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-bottom: 30px;
    }

    .payment-option {
      background-color: var(--card-bg);
      border-radius: 10px;
      padding: 20px;
      cursor: pointer;
      transition: all 0.3s;
      border: 2px solid transparent;
    }

    .payment-option:hover {
      border-color: var(--neon-blue);
      box-shadow: 0 0 15px rgba(5, 217, 232, 0.3);
    }

    .payment-option.active {
      border-color: var(--neon-green);
      box-shadow: 0 0 20px rgba(0, 255, 157, 0.4);
    }

    .payment-option h3 {
      color: var(--neon-blue);
      margin-top: 0;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .payment-option p {
      margin-bottom: 0;
      color: #aaa;
    }

    .payment-details {
      display: none;
      margin-top: 20px;
      padding: 20px;
      background-color: rgba(26, 26, 46, 0.7);
      border-radius: 8px;
      border-left: 3px solid var(--neon-purple);
    }

    .payment-details.active {
      display: block;
      animation: fadeIn 0.5s;
    }

    .qr-code-placeholder {
      width: 200px;
      height: 200px;
      margin: 0 auto;
      background-color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      color: black;
      font-weight: bold;
      border-radius: 8px;
    }

    .upi-options {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 15px;
    }

    .upi-option {
      padding: 10px 15px;
      background-color: rgba(5, 217, 232, 0.1);
      border-radius: 5px;
      border: 1px solid var(--neon-blue);
      transition: all 0.3s;
    }

    .upi-option:hover {
      background-color: rgba(5, 217, 232, 0.3);
    }

    .payment-summary {
      background-color: var(--card-bg);
      border-radius: 10px;
      padding: 20px;
      margin-top: 30px;
      border-top: 3px solid var(--neon-pink);
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .total-row {
      font-size: 1.2rem;
      font-weight: bold;
      color: var(--neon-green);
      margin-top: 15px;
      padding-top: 15px;
      border-top: 1px solid var(--neon-purple);
    }

    .checkout-btn {
      width: 100%;
      padding: 15px;
      border-radius: 50px;
      background-color: var(--neon-pink);
      color: white;
      border: none;
      font-family: 'Orbitron', sans-serif;
      font-weight: bold;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 20px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .checkout-btn:hover {
      background-color: transparent;
      border: 2px solid var(--neon-pink);
      box-shadow: 0 0 20px var(--neon-pink);
    }

    .invoice-btn {
      width: 100%;
      padding: 15px;
      border-radius: 50px;
      background-color: var(--neon-purple);
      color: white;
      border: none;
      font-family: 'Orbitron', sans-serif;
      font-weight: bold;
      font-size: 1.1rem;
      cursor: pointer;
      transition: all 0.3s;
      margin-top: 15px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .invoice-btn:hover {
      background-color: transparent;
      border: 2px solid var(--neon-purple);
      box-shadow: 0 0 20px var(--neon-purple);
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

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .hidden {
      display: none;
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>CHECKOUT</h1>
    <p>Complete your order</p>
  </div>

  <div class="checkout-container">
    <form method="post">
      <div class="payment-methods">
        <div class="payment-option active" onclick="selectPayment('cod')">
          <h3><i class="bi bi-cash-coin"></i> Cash on Delivery</h3>
          <p>Pay when you receive your order</p>
          <div class="payment-details active" id="cod-details">
            <p>Our delivery executive will collect payment when your order arrives.</p>
            <p>Please keep exact change ready.</p>
          </div>
        </div>
        <div class="payment-option" onclick="selectPayment('qr')">
          <h3><i class="bi bi-qr-code-scan"></i> Scan QR Code</h3>
          <p>Scan with any UPI app</p>
          <div class="payment-details" id="qr-details">
            <center><img src="qr.jpg"></center>
            <p style="text-align: center; margin-top: 15px;">Scan this QR code with your UPI app to complete payment</p>
            <div style="text-align: center; margin-top: 10px;">
              <p>UPI ID: 7718883299-2@axl</p>
            </div>
          </div>
        </div>
        <div class="payment-option" onclick="selectPayment('upi')">
          <h3><i class="bi bi-phone"></i> Pay via UPI</h3>
          <p>Instant payment with any UPI app</p>
          <div class="payment-details" id="upi-details">
            <p>Choose your preferred UPI app:</p>
            <div class="upi-options">
              <div class="upi-option">Google Pay</div>
              <div class="upi-option">PhonePe</div>
              <div class="upi-option">Paytm</div>
              <div class="upi-option">BHIM</div>
              <div class="upi-option">Amazon Pay</div>
            </div>
            <p style="margin-top: 15px;">UPI ID: 7718883299-2@axl</p>
          </div>
        </div>
      </div>
      <input type="hidden" name="payment_method" id="payment_method" value="cod">
      <div class="payment-summary">
        <div class="summary-row">
          <span>Subtotal:</span>
          <span>₹<?php echo number_format($cart_total, 2); ?></span>
        </div>
        <div class="summary-row">
          <span>Delivery Fee:</span>
          <span>₹0.00</span>
        </div>
        <div class="summary-row">
          <span>Tax (5%):</span>
          <span>₹<?php echo number_format($cart_total * 0.05, 2); ?></span>
        </div>
        <div class="summary-row total-row">
          <span>Total:</span>
          <span>₹<?php echo number_format($cart_total * 1.05, 2); ?></span>
        </div>
        <button type="submit" name="place_order" class="checkout-btn">
          Place Order <i class="bi bi-arrow-right"></i>
        </button>
        <button type="submit" name="generate_invoice" class="invoice-btn">
          Download Invoice <i class="bi bi-file-earmark-pdf"></i>
        </button>
      </div>
    </form>
  </div>

  <script>
    function selectPayment(method) {
      document.querySelectorAll('.payment-option').forEach(option => {
        option.classList.remove('active');
      });
      document.querySelector(`.payment-option[onclick="selectPayment('${method}')"]`).classList.add('active');

      document.querySelectorAll('.payment-details').forEach(details => {
        details.classList.remove('active');
      });
      document.getElementById(`${method}-details`).classList.add('active');

      document.getElementById('payment_method').value = method;
    }
  </script>
</body>
</html>