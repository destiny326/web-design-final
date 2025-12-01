<?php
session_start();
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// Handle clear cart
if (isset($_POST["clear"])) {
    $_SESSION["cart"] = [];
    echo json_encode(["success" => true, "subtotal" => 0, "total" => 0]);
    exit;
}

$index = intval($_POST["index"] ?? -1);
$quantity = intval($_POST["quantity"] ?? 0);

if ($index >= 0 && isset($_SESSION["cart"][$index])) {
    if ($quantity > 0) {
        $_SESSION["cart"][$index]["quantity"] = $quantity;
    } else {
        array_splice($_SESSION["cart"], $index, 1);
    }
}

// Recalculate totals
$total = 0;
foreach ($_SESSION["cart"] as $item) {
    $total += $item["price"] * $item["quantity"];
}

$subtotal = ($index >= 0 && isset($_SESSION["cart"][$index]))
    ? $_SESSION["cart"][$index]["price"] * $_SESSION["cart"][$index]["quantity"]
    : 0;

echo json_encode([
    "success" => true,
    "subtotal" => $subtotal,
    "total" => $total

    <button onclick="confirmClearCart()">Clear Cart</button>

<script>
function confirmClearCart() {
  // Show a confirmation dialog
  if (confirm("Are you sure you want to clear your cart?")) {
    // If user clicks OK, call clearCart()
    clearCart();
  }
}

function clearCart() {
  fetch("update_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "clear=1"
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      // Remove all rows from the cart table
      const tbody = document.querySelector("#cart-table tbody");
      if (tbody) tbody.innerHTML = "";
      // Reset total
      document.getElementById("total").textContent = "0";
    }
  });
}
</script>

]);
