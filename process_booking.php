<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$user_id = $_SESSION["id"];
$event_id = intval($_POST["event_id"]);
$quantity = intval($_POST["quantity"]);

// Insert booking
$sql = "INSERT INTO Tickets (event_id, user_id, quantity, status) VALUES (?, ?, ?, 'booked')";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "iii", $event_id, $user_id, $quantity);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Reduce available tickets
$sql = "UPDATE Events SET available_tickets = available_tickets - ? WHERE id = ?";
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "ii", $quantity, $event_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);

// Redirect to dashboard
header("location: dashboard.php");
exit;
?>
