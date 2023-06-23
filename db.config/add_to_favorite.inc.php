<?php
session_start();
include('db_conn.php');

// Check if the user is logged in
if (!isset($_SESSION['userId'])) {
    echo "There is no session";
    exit();
}

// Get the user ID from the session
$userId = $_SESSION['userId'];

// Get the post ID from the AJAX request
if (isset($_POST['postId'])) {
    $postId = $_POST['postId'];
} else {
    echo "Invalid request";
    exit();
}


$query = "SELECT * FROM favorites WHERE user_id = '$userId' AND post_id = '$postId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo "Post already in favorites";
} else {
    $insertQuery = "INSERT INTO favorites (user_id, post_id,created_at) VALUES ('$userId', '$postId',NOW())";
    if ($conn->query($insertQuery)) {
        echo "Post added to favorites";
    } else {
        echo "Failed to add post to favorites";
    }
}
