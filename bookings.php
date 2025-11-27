<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if (!isset($_GET["event_id"])) {
    die("No event selected.");
}
$event_id = intval($_GET["event_id"]);

// Fetch event details
$sql = "SELECT id, title, description, date, venue, ticket_price, available_tickets 
        FROM Events WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $event_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$event = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($conn);

if (!$event) {
    die("Event not found.");
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = intval($_POST["quantity"]);
    if ($quantity > 0 && $quantity <= $event["available_tickets"]) {
        // Add to cart (session)
        $_SESSION["cart"][] = [
            "event_id" => $event["id"],
            "title" => $event["title"],
            "date" => $event["date"],
            "venue" => $event["venue"],
            "price" => $event["ticket_price"],
            "quantity" => $quantity
        ];
        header("location: Cart.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Ticket</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <h2><?php echo htmlspecialchars($event["title"]); ?></h2>
  <p><strong>Date:</strong> <?php echo htmlspecialchars($event["date"]); ?></p>
  <p><strong>Venue:</strong> <?php echo htmlspecialchars($event["venue"]); ?></p>
  <p><strong>Price:</strong> $<?php echo htmlspecialchars($event["ticket_price"]); ?></p>
  <p><strong>Available Tickets:</strong> <?php echo htmlspecialchars($event["available_tickets"]); ?></p>
  <p><?php echo nl2br(htmlspecialchars($event["description"])); ?></p>

  <form method="post">
    <label>Quantity:</label>
    <input type="number" name="quantity" min="1" max="<?php echo $event["available_tickets"]; ?>" required>
    <button type="submit">Add to Cart</button>
  </form>
</body>
</html>
