<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$AZURE_MYSQL_HOST = "cst407t6webapplication-server.mysql.database.azure.com";
$AZURE_MYSQL_PORT = "3306"; // If you're using the default port (3306) for MySQL, then you might not actually need this line.
$AZURE_MYSQL_USERNAME = "cory";
$AZURE_MYSQL_PASSWORD = "L3T0H27KBRHX76IP$";
$AZURE_MYSQL_DATABASE = "jokes";

// Use the right variable names here
$mysqli = new mysqli($AZURE_MYSQL_HOST, $AZURE_MYSQL_USERNAME, $AZURE_MYSQL_PASSWORD, $AZURE_MYSQL_DATABASE);

if ($mysqli->connect_error) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo $mysqli->host_info . "<br>";

?>