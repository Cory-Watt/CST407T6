<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db_connect.php";
$new_username = $_GET['username'];
$new_password1 = $_GET['password'];
$new_password2 = $_GET['password-confirm'];

echo "<h2>Trying to add a new user " . $new_username . " pw =  " . $new_password1 . " and " . $new_password2 . "</h2>";

// Check if this username has already been registered.
$stmt = $mysqli->prepare("SELECT * FROM users WHERE user_name = ?");
$stmt->bind_param('s', $new_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "The username " . $new_username . " is already in use. Try another.";
    exit;
}
// Check if the password fields match
else if ($new_password1 != $new_password2) {
    echo "The passwords do not match. Please try again.";
    exit;
} else if (strlen($new_password1) < 8) {
    echo "The password must be at least 8 characters long. Please try again.";
    exit;
} else if (!preg_match('/[0-9]/', $new_password1)) {
    echo "The password must contain at least one number. Please try again.";
    exit;
} else if (!preg_match('/[^a-zA-Z0-9\s]/', $new_password1)) {
    echo "The password must contain at least one special character. Please try again.";
    exit;
} else {
    // Hash the password before storing
    $hashedPassword = password_hash($new_password1, PASSWORD_DEFAULT);

    // Get information about the password hash
    $password_info = password_get_info($hashedPassword);

    // Display the password info (this is just for demonstration; typically you'd not display this)
    echo "Password Hash Information: <pre>";
    print_r($password_info);
    echo "</pre>";

    // Add the new user
    $stmt = $mysqli->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
    $stmt->bind_param('ss', $new_username, $hashedPassword);
    $result = $stmt->execute();

    if ($result) {
        echo "Registration success!";
    } else {
        echo "Something went wrong. Not registered.";
    }
}

echo "<a href='index.php'>Return to main</a>";

$stmt->close();
$mysqli->close();
?>