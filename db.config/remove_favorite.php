<?php
include("db_conn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['favorite_id'])) {
        $favoriteId = $_POST['favorite_id'];

        // Delete the favorite post from the favorites table
        $sql = "DELETE FROM favorites WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $favoriteId);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            // Favorite post removed successfully
            $response = "Favorite post removed successfully.";
            echo $response;
        } else {
            // Failed to remove favorite post
            $response = "Failed to remove favorite post.";
            echo $response;
        }

        // Clean up
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
