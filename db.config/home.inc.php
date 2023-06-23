<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

include("db_conn.php");


// Checking if the form is submitted
if (isset($_GET["search"])) {
    $search = $_GET['search'];

    $search = mysqli_real_escape_string($conn, $search);

    $sql = "SELECT * FROM user WHERE name LIKE '$search%'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        $error = "There is no account with this name";
    }
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        if ($status == "deactivated") {
            $error = "This account is deactivated";
        } else {
            $id = $row['id'];
            header("Location: userProfile.php?id=$id");
            exit();
        }
    }
}

// $sql = "SELECT p.id, u.name, p.title, u.image, p.content, p.created_at 
// FROM post p 
// JOIN user u ON u.id = p.user_id 
// ORDER BY p.created_at DESC";

// $result = mysqli_query($conn, $sql);
// // Display the post
// while ($row = mysqli_fetch_assoc($result)) {
//     // Get the post data
//     $postId = $row['id'];
//     $title = $row['title'];
//     $caption = $row['content'];
//     $createdAt = $row['created_at'];
//     $username = $row['name'];
//     $userImage = $row['image'];
// }

function formatDate($date)
{
    $timestamp = strtotime($date);
    $now = time();
    $diff = $now - $timestamp;

    if ($diff < 60) {
        return "now";
    } elseif ($diff < 3600) {
        $minutes = round($diff / 60);
        return "$minutes m";
    } elseif ($diff < 86400) {
        $hours = round($diff / 3600);
        return "$hours.h";
    } else {
        $days = round($diff / 86400);
        return "$days d";
    }
}

$sql = "SELECT p.id, u.name, p.title,p.user_id, u.image, p.content, p.created_at,like_count,hide_counts,hide_comment
FROM post p 
JOIN user u ON u.id = p.user_id 
ORDER BY p.created_at DESC";

$result = mysqli_query($conn, $sql);


if (isset($_SESSION['report_success']) && $_SESSION['report_success']) {
    echo '<script>
        setTimeout(function() {
            Swal.fire({
                icon: "success",
                title: "Report successfully submitted!",
                showConfirmButton: false,
                timer: 2000
            });
        }, 100);
    </script>';
    $_SESSION['report_success'] = false;
}

if (isset($_POST['delete'])) {
    // Retrieve the post ID from the form action

    $postId = $_POST['postId'];

    $postId = mysqli_real_escape_string($conn, $postId);
    $postId = filter_var($postId, FILTER_VALIDATE_INT);

    $query = "DELETE FROM post WHERE id = $postId";
    $deleteResult = mysqli_query($conn, $query);

    if ($deleteResult) {
        header("Location: profile.php");
        $_SESSION['post-deleted'] = "true";
        exit();
    } else {
        // Deletion failed
        echo "Error deleting the post.";
    }
}

if (isset($_SESSION['post-deleted']) && $_SESSION['post-deleted']) {
    echo '
    <script>
        setTimeout(function() {
            
            Swal.fire({
                icon: "success",
                title: "Post successfully deleted!",
                showConfirmButton: false,
                timer: 2000
            });
        }, 100);
    </script>';
    $_SESSION['post-deleted'] = false;
}



// delete_post.php
