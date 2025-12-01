<?php
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection settings for MAMP
$servername = "localhost";
$username   = "root";      // MAMP default
$password   = "root";      // MAMP default
$dbname     = "stagepass_db"; // replace with your actual DB name
$port       = 3306;        // MAMP MySQL port

// Try to connect
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

if (!$conn) {
    die("❌ Connection failed: " . mysqli_connect_error());
}
echo "✅ Connected successfully to database '$dbname' on port $port";

// Optional: run a simple query
$sql = "SHOW TABLES";
$result = mysqli_query($conn, $sql);

echo "<h3>Tables in '$dbname':</h3><ul>";
while ($row = mysqli_fetch_row($result)) {
    echo "<li>" . htmlspecialchars($row[0]) . "</li>";
}
echo "</ul>";

mysqli_close($conn);
?>
