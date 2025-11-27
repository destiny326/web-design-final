<?php
// Initialize the session
session_start();

// Redirect if not logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Get current user ID
$user_id = $_SESSION["id"];

// Example query: fetch tickets/events for this user
$sql = "SELECT event_name, event_date, ticket_number 
        FROM Tickets 
        WHERE user_id = ? 
        ORDER BY event_date ASC";

$events = [];
if ($stmt = mysqli_prepare($conn, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 80%; margin: 50px auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?>!</h2>
        <hr>
        <h3>Your Tickets</h3>

        <?php if (!empty($events)): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Ticket #</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event["event_name"]); ?></td>
                            <td><?php echo htmlspecialchars($event["event_date"]); ?></td>
                            <td><?php echo htmlspecialchars($event["ticket_number"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You don’t have any tickets yet.</p>
        <?php endif; ?>

        <p><a href="logout.php" class="btn btn-danger">Logout</a></p>
    </div>
</body>
</html>
   