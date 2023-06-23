<?php

include("./db_conn.php");

// Start the session
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['commentId'];

    // Check if the comment ID is already liked in the current session
    if (!isset($_SESSION['liked_comments'][$commentId])) {

        // Update the like_count value in the database
        $sql = "UPDATE post SET like_count = like_count + 1 WHERE id = $commentId";
        $result = $conn->query($sql);

        if ($result) {
            // Retrieve the updated like count from the database
            $sql = "SELECT like_count FROM post WHERE id = $commentId";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $likeCount = $row['like_count'];

            // Store the comment ID as liked in the current session
            $_SESSION['liked_comments'][$commentId] = $likeCount;

            // Return the updated like count as the response
            echo $likeCount;
        } else {
            echo "Failed to update like count.";
        }
    } else {
        // Decrease the like_count value in the database
        $sql = "UPDATE post SET like_count = like_count - 1 WHERE id = $commentId";
        $result = $conn->query($sql);

        if ($result) {
            // Retrieve the updated like count from the database
            $sql = "SELECT like_count FROM post WHERE id = $commentId";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $likeCount = $row['like_count'];

            // Remove the comment ID from liked comments in the current session
            unset($_SESSION['liked_comments'][$commentId]);

            // Return the updated like count as the response
            echo $likeCount;
        } else {
            echo "Failed to update like count.";
        }
    }
}
