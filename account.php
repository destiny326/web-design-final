<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Account</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <h2>Account Details</h2>
  <p>Name: <?php echo htmlspecialchars($_SESSION["name"]); ?></p>
  <p>Email: <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
  <a href="dashboard.php">View My Tickets</a>
</body>
</html>
