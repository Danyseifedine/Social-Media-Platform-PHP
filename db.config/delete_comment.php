<?php
include("db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $commentId = $_POST['comment_id'];

    $sql = "DELETE FROM comment WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $commentId);

    if (mysqli_stmt_execute($stmt)) {
        echo "Comment deleted successfully.";
    } else {
        echo "Failed to delete comment.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
