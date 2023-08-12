<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db_connect.php";

$user_name = $_POST['user_name'];
$password = $_POST['password'];

echo "<h2>You attempted to login with " . $user_name . " and " . $password . "</h2>";

// Prepare the SQL statement using placeholders
$stmt = $mysqli->prepare("SELECT user_id, user_name, password FROM users WHERE user_name = ? AND password = ?");

// Bind the input values to the placeholders
$stmt->bind_param("ss", $user_name, $password);

// Execute the prepared statement
$stmt->execute();

// Bind the result set columns to PHP variables
$stmt->bind_result($user_id, $retrieved_user_name, $retrieved_password);

// Display the SQL
echo "SQL = SELECT user_id, user_name, password FROM users WHERE user_name = ? AND password = ?<br>";

// Fetch the results
if ($stmt->fetch()) {
    // Log the user in
    echo "<p>Login success</p>";
    $_SESSION['user_name'] = $retrieved_user_name;
    $_SESSION['userid'] = $user_id;
} else {
    echo "Login failed.<br>";
    $_SESSION = [];
    session_destroy();
}

$stmt->close();

echo "Session variable = ";
print_r($_SESSION);

echo "<br>";

echo "<a href='index.php'>Return to main page</a>";
?>