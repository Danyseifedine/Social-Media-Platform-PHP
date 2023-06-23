<?php
include_once("./db.config/db_conn.php");
session_start();


$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}
include_once("./db.config/home.inc.php");

$id = $_SESSION['userId'];

$sql = "SELECT u.id , p.id, f.id as favorite_id, f.post_id, p.user_id,p.title as title,p.like_count as like_count,p.content as content,p.hide_counts as hide_counts,p.created_at as created_at,u.name as name, u.image as image, p.hide_comment as hide_comment
FROM post AS p
JOIN favorites AS f ON p.id = f.post_id
JOIN user AS u ON p.user_id = u.id
WHERE f.user_id = $id;";

$result = mysqli_query($conn, $sql);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./css/home.css">
    <link rel="stylesheet" href="./css/menu_post.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Document</title>
</head>

<style>
    .liked {
        color: red !important;
    }
</style>

<body>
    <nav style="position: fixed; z-index:1;">
        <ul>
            <li class="pb-5 mb-5">
                <a href="./profile.php">
                    <img src="./images/<?php echo $_SESSION['image'];
                                        ?>" alt="">
                    <span class="nav-item"><?php
                                            echo       $_SESSION['name'] ?></span>
                </a>
            </li>
            <li><a href="./profile.php">
                    <i class="bi bi-person-circle"></i>
                    <span class="nav-item">Profile</span>
                </a>
            </li>
            <li><a href="./home.php">
                    <i class="bi bi-house-door"></i>

                    <span class="nav-item">Home</span>
                </a></li>
            <li><a href="./explore.php">
                    <i class="bi bi-hash"></i>

                    <span class="nav-item">Explore</span>
                </a></li>
            <li><a href="#">
                    <i class="bi bi-chat-left-dots"></i>

                    <span class="nav-item">Messages</span>
                </a>
            </li>
            <li><a href="./notifcation.php">
                    <i class="bi bi-bell-fill"></i>
                    <span class="nav-item">Notifications</span>
                </a>
            </li>
            <li><a href="./add_post.php">
                    <i class="bi bi-file-post"></i>

                    <span class="nav-item">Add post</span>
                </a>
            </li>
            <li><a href="./setting.php">
                    <i class="bi bi-gear"></i>

                    <span class="nav-item">Setting</span>
                </a>
            </li>
            <li><a href="./favorite.php">
                    <i class="bi bi-star-fill"></i>

                    <span class="nav-item">Favorites</span>
                </a>
            </li>
            <li><a href="logout.php" class="logout">
                    <i class="bi bi-door-open-fill"></i>
                    <span class="nav-item" id="logoutButton">Log out</span>
                </a></li>
            <button id="modeButton" class="mode " onclick="ChangeMode()"></button>

        </ul>

    </nav>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Get the post data
            $hide_count = $row['hide_counts'];
            $hide_comment = $row['hide_comment'];
            $like_count = $row['like_count'];
            $postId = $row['id'];
            $title = $row['title'];
            $caption = $row['content'];
            $createdAt = $row['created_at'];
            $username = $row['name'];
            $userImage = $row['image'];
            $userId = $row['user_id'];
            $favorite_id = $row['favorite_id'];


            echo '<div class="container post-home-card pt-4">';
            echo '<div class="time-user-edit">';
            echo '<div class="user-post-data d-flex align-items-center" style="gap:10px;">';
            echo '<div class="user-post-image-data">';
            echo '<button class="delete-favorite" style="background:transparent;" data-favorite-id="' . $favorite_id . '"><i class="bi bi-trash" style="font-size:20px"></i>';
            echo "<img src='./images/$userImage' alt='' style='width: 40px; height:40px;border-radius:50%'>";
            echo '</div>';

            echo "<div class='username-post-data'><a href='userProfile.php?id=$userId'><p style='margin-bottom: 0;margin-right:10px'>$username</p></a></div>";
            echo "<div class='date-post-data'><p style='margin-bottom: 0;margin-right:30px'>" . formatDate($createdAt) . "</p></div>";
            echo '<div class="edit-post-data"><button id="menu-button" class="menu-button mb-4" style="background-color: transparent;"><i class="bi bi-list"></i></button></div>';
            echo '</div></div>';

            echo "<div class='main-post-image'><img src='./images/$title' alt=''></div>";
        }
    } else {
        echo "<div style='display:flex;justify-content:center;align-items:center;min-height:100vh;'>there is no favorite posts</div>";
    }


    ?>

    <script src=" ./js/script.js"></script>

    <script>
        $(".delete-favorite").click(function() {
            var favoriteId = $(this).data('favorite-id');

            console.log(favoriteId);

            $.ajax({
                url: './db.config/remove_favorite.php',
                type: 'POST',
                data: {
                    favorite_id: favoriteId
                },
                success: function(response) {
                    console.log(response);
                    // Remove the favorite post from the favorites page
                    location.reload();

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });
    </script>