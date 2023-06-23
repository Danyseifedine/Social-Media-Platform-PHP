<?php

require_once "./db.config/db_conn.php";
$postId = $_GET['id'];

if (empty($postId)) {
    header("location:/full_project/home.php");
}

$query = "SELECT p.id, u.name, p.user_id, p.title, u.image, p.content, p.created_at 
            FROM post p 
            JOIN user u ON u.id = p.user_id 
            WHERE p.id = $postId";

$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$userId = $row['user_id'];
$postId = $row['id'];
$title = $row['title'];
$caption = $row['content'];
$createdAt = $row['created_at'];
$username = $row['name'];
$userImage = $row['image'];

if (isset($_POST["submit"])) {
    $reason = $_POST['reason'];
    $details = $_POST['details'];

    $reason = mysqli_real_escape_string($conn, $reason);
    $details = mysqli_real_escape_string($conn, $details);

    $sql = "INSERT INTO report (post_id, user_id, reason, report_text, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiss", $postId, $userId, $reason, $details);
    mysqli_stmt_execute($stmt);

    if (mysqli_error($conn)) {
        echo "Error: " . mysqli_error($conn);
    }

    $_SESSION['report_success'] = true;


    header("location: home.php");
    exit();
}
