<?php
include("db_conn.php");


session_start();
if (isset($_POST['post_id'])) {
    $postId = $_POST['post_id'];

    // Fetch comments from the database for the specific post_id along with user information
    $sql = "SELECT c.comment, c.created_at, c.user_id as us_id, u.name,c.id as id,u.id as user_id
            FROM comment c
            INNER JOIN user u ON c.user_id = u.id
            WHERE c.post_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Construct the HTML markup for the comments
    $commentsHTML = '';
    while ($row = mysqli_fetch_assoc($result)) {
        $commentId = $row['id'];
        $commentText = $row['comment'];
        $createdAt = $row['created_at'];
        $userName = $row['name'];
        $user_id = $row['user_id'];
        $us_id = $row['us_id'];

        // Construct HTML for each comment
        $commentsHTML .= '<div class="comment" style="margin-left:5%;margin-bottom:3%;padding-right:0%">';
        $commentsHTML .= "";
        $commentsHTML .= "<p style='font-size:15px;margin-bottom:0;word-break:break-all;'><span style='font-weight:bold; font-size:17px'>$userName :</span> $commentText</p>";
        $commentsHTML .= "<span style='font-size:15px;opacity:0.5'> $createdAt</span>";
        $commentsHTML .= "<br>";
        if ($user_id == $_SESSION['userId']) {
            $commentsHTML .= '<button class="delete-comment" style="background:transparent;" data-comment-id="' . $commentId . '"><i class="bi bi-trash" style="font-size:20px"></i>
            </button>';
        }
        $commentsHTML .= '</div>';
    }

    // Echo the comments HTML
    echo $commentsHTML;

    // Clean up
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
