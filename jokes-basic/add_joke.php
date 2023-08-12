<?php
session_start();

// Check if 'user_name' is set in the session.
if (!isset($_SESSION['user_name']) || !$_SESSION['user_name']) {
    echo "Only logged in users may access this page.  Click <a href='login_form.php'>here</a> to login.<br>";
    exit;
}

include "db_connect.php";

$new_joke_question = addslashes($_GET['newjoke']);
$new_joke_answer = addslashes($_GET['jokeanswer']);
$userid = $_SESSION['userid'];

echo "<h2>Trying to add a new joke " . $new_joke_question . " and " . $new_joke_answer . "</h2>";

// You can skip JokeID since it's probably an auto-increment field.
$stmt = $mysqli->prepare("INSERT INTO Jokes_table (Joke_question, Joke_answer, user_id) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $new_joke_question, $new_joke_answer, $userid);

$stmt->execute();
$stmt->close();

include "search_all_jokes.php";

echo "<a href='index.php'>Return to main</a>";
?>