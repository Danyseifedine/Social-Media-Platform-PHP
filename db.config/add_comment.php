<?php

include("db_conn.php");
session_start();
$userId = $_SESSION['userId'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $comment = $_POST['comment'];
    $postId = $_POST['post_id'];


    if (empty($comment)) {
    } else {
        $pattern = "/^[a-zA-Z0-9\s]+$/";
        if (!preg_match($pattern, $comment)) {
        } else {

            $sql = "INSERT INTO comment (user_id, post_id, comment, created_at) VALUES (?, ?, ?, NOW())";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iis", $userId, $postId, $comment);

            if (mysqli_stmt_execute($stmt)) {
                echo "Comment added successfully.";
            } else {
                echo "Failed to add comment.";
            }

            mysqli_stmt_close($stmt);
            mysqli_close($conn);
        }
    }
}
