<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ margin-top: 50px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>Welcome, <b><?php echo htmlspecialchars($_SESSION["name"]); ?></b>!</h1>
        <p>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </p>
    </div>
</body>
</html>
