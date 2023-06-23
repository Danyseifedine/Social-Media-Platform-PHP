<?php
include_once("./db.config/db_conn.php");
session_start();


$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}
include_once("./db.config/home.inc.php");
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
    <div class="home-page" style="padding-top:2%; position:relative">
        <form action="home.php" method="get" class="d-flex align-items-center justify-content-center" style="gap: 70px;">
            <div class="search">

                <input type="text" class="search__input" placeholder="<?php echo isset($error) ? $error : 'Search...' ?>" name="search">
                <button class="search__button">
                </button>
            </div>
            <div class="home-suggested">
                <div class="user-card">
                    <div class="user-card-image d-flex align-items-center" style="gap: 10px;">
                        <img src="./images/<?php echo $_SESSION['image'] ?>">
                        <div>
                            <a href="profile.php">
                                <p class="" style="margin: 0;"><?php echo $_SESSION['name'] ?></p>
                            </a>
                            <a href="profile.php">
                                <p class="" style="margin: 0;"><?php echo $_SESSION['email'] ?></p>
                            </a>
                        </div>
                        <div>
                            <a href="logout.php" class="pl-5" style="color: #007bff;">switch</a>
                        </div>
                    </div>
                </div>
        </form>
    </div>
    <?php

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

        echo '<div class="container post-home-card pt-4">';
        echo '<div class="time-user-edit">';
        echo '<div class="user-post-data d-flex align-items-center" style="gap:10px;">';
        echo '<div class="user-post-image-data">';
        echo "<img src='./images/$userImage' alt='' style='width: 40px; height:40px;border-radius:50%'>";
        echo '</div>';

        echo "<div class='username-post-data'><a href='userProfile.php?id=$userId'><p style='margin-bottom: 0;margin-right:10px'>$username</p></a></div>";
        echo "<div class='date-post-data'><p style='margin-bottom: 0;margin-right:30px'>" . formatDate($createdAt) . "</p></div>";
        echo '<div class="edit-post-data"><button id="menu-button" class="menu-button mb-4" style="background-color: transparent;"><i class="bi bi-list"></i></button></div>';
        echo '</div></div>';

        echo "<div class='main-post-image'><img src='./images/$title' alt=''></div>";
        echo '<div class="description-post">';
        echo '<div class="like">';
        echo '<i class="likeButton bi bi-heart-fill heart" style="color:red;" data-comment-id="' . $postId . '" style="cursor:pointer;font-size:27px"></i>';
        echo '<i class="bi bi-chat-left-text" style="font-size: 27px;"></i>';
        echo '<i class="bi bi-send" style="font-size: 27px;"></i>';
        echo '<i class="bi bi-tag tag" style="font-size: 27px; cursor:pointer"></i>';
        echo '</div>';


        echo '<div class="like-count d-flex pt-4" style="gap: 2px;">';
        if ($hide_count == 1 || $userId == $_SESSION['userId']) {
            echo '<p class="likeCount">' . $like_count . '</p>';
            echo '<p>like</p>';
        } else {
            echo "Hidden";
        }
        echo '</div>';
        if ($hide_comment == 1) {

            echo '<div class="desc-post">';
            echo "<p>$caption</p>";
            echo '</div>';
            echo '<div class="post-container" data-post-id="' . $postId . '">';
            echo '<div class="comments-container"></div>';
            echo '<div class="add-comment">';
            echo '<form class="comment-form">';
            echo '<div class="comment-place"></div>';
            echo '<div class="input-group">';
            echo '<textarea name="comment" class="form-control comment" style="border:transparent;border-bottom:1px solid grey" placeholder="comment..."></textarea>';
            echo '<div class="input-group-append">';
            echo '<button class="btn btn-sm btn-primary" type="submit">Post</button>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        }

        // Menu Options

        if ($_SESSION["userId"] == $userId) {
            echo '<div id="" class="menu-opt hide">';
            echo '<div class="menu-options">';
            echo '<button><a href="report.php?id=' . $postId . '" style="color:red">Report</a></button>';
            echo '<button><a href="edit_post.php?id=' . $postId . '" style="color:black">Edit</a></button>';
            echo '<form action="home.php" method="POST" style="display:flex;flex-direction:column">';
            echo '<input type="hidden" name="postId" value="' . $postId . '">';
            echo '<button type="submit" name="delete">Delete</button>';
            echo '<button onclick="copyToClipboard(event, this)">Copy link</button>';
            echo '</form>';
            echo '<button id="back-button" class="back-button" style="color:red">Back</button>';
            echo '</div>';
            echo '</div>';
        } else {
            echo '<div id="" class="menu-opt hide">';
            echo '<div class="menu-options">';
            echo '<button><a href="report.php?id=' . $postId . '" style="color:red">Report</a></button>';
            echo '<button onclick="copyToClipboard(event, this)">Copy link</button>';
            echo '<button class="addToFavorite" data-postid="' . $postId . '">Add to favorite</button>';
            echo '<button id="back-button" class="back-button" style="color:red">Back</button>';
            echo '</div>';
            echo '</div>';
            echo '</div></div>';
        }
    }
    ?>

    <!-- Include the JavaScript code -->
    <script>

    </script>


</body>
<script src=" ./js/script.js"></script>
<script src="./js/home.js"></script>
<script src="./js/copy_link.js"></script>
<script>
    $(document).ready(function() {

        var postId = <?php echo $postId; ?>;

        var userId = "<?php echo $_SESSION['userId']; ?>";

        var likedPosts = JSON.parse(localStorage.getItem(userId)) || [];

        function updateLikeCount(commentId, button) {
            $.ajax({
                url: "http://university.test/full_project/db.config/like.inc.php",
                method: "POST",
                data: {
                    commentId: commentId
                },
                success: function(response) {
                    // Update the like count on the page
                    var likeCountElement = button.closest('.description-post').find('.likeCount');
                    var likeCount = parseInt(response, 10);

                    if (isNaN(likeCount)) {
                        // Handle parsing error or assign a fallback value
                        likeCount = 0;
                    }

                    likeCountElement.text(likeCount);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Update like count AJAX request failed:", textStatus, errorThrown);
                }
            });
        }

        // Attach click event to the like button
        $(document).on("click", ".likeButton", function() {
            var commentId = $(this).data("comment-id");
            var button = $(this);

            if (likedPosts.includes(commentId)) {
                likedPosts = likedPosts.filter(function(postId) {
                    return postId !== commentId;
                });

                button.removeClass("liked");
            } else {
                likedPosts.push(commentId);

                button.addClass("liked");
            }

            localStorage.setItem(userId, JSON.stringify(likedPosts));

            updateLikeCount(commentId, button);
        });

        $(".likeButton").each(function() {
            var commentId = $(this).data("comment-id");

            if (likedPosts.includes(commentId)) {
                $(this).addClass("liked");
            }
        });


        $(document).on("click", ".addToFavorite", function() {
            var postId = $(this).data("postid");

            $.ajax({
                url: "http://university.test/full_project/db.config/add_to_favorite.inc.php",
                method: "POST",
                data: {
                    postId: postId
                },
                success: function(response) {

                    if (response === "Post added to favorites") {
                        $(".addToFavorite").html("Post added to favorites")
                        setTimeout(() => {
                            $(".addToFavorite").html("Add to favorite")
                        }, 4000);
                    } else if (response === "Post already in favorites") {
                        $(".addToFavorite").html("Post already in favorites")
                        setTimeout(() => {
                            $(".addToFavorite").html("Add to favorite")
                        }, 4000);
                    } else {
                        alert("Failed to add post to favorites");
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("AJAX request failed:", textStatus, errorThrown);
                }
            });
        });

        $(".comment-form").submit(function(event) {
            event.preventDefault();

            var comment = $(this).find("textarea.comment").val();

            var postId = $(this).closest(".post-container").data("post-id");


            $.ajax({
                url: './db.config/add_comment.php',
                type: 'POST',
                data: {
                    comment: comment,
                    post_id: postId
                },
                success: function(response) {
                    $('.comment-form').find("textarea.comment").val('');
                    fetchComments(postId);

                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });


        function fetchComments(postId) {
            $.ajax({
                url: "./db.config/fetch_comment.php",
                type: "POST",
                data: {
                    post_id: postId
                },
                success: function(response) {
                    // Find the comments container for the corresponding post
                    var commentsContainer = $("[data-post-id=" + postId + "]").find(".comments-container");
                    console.log(commentsContainer);
                    // Update the comments container with the fetched comments
                    commentsContainer.html(response);
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }


        $(".post-container").each(function() {
            var postId = $(this).data("post-id");
            fetchComments(postId);
        });

        $(document).on('click', '.delete-comment', function() {
            var commentId = $(this).data('comment-id');
            var commentContainer = $(this).closest('.comment');

            $.ajax({
                url: './db.config/delete_comment.php',
                type: 'POST',
                data: {
                    comment_id: commentId
                },
                success: function(response) {
                    console.log(response);
                    // Slide up the comment container and remove it after the animation completes
                    commentContainer.slideToggle('slow', function() {
                        $(this).remove();
                    });
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        });

    });
</script>
<style>

</style>






</html>