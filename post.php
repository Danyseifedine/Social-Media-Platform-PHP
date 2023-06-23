<?php
// Include database connection code

session_start();
require_once "./db.config/db_conn.php";

include_once("./db.config/home.inc.php");


$postId = $_GET['post_id'];

$sql = "SELECT p.id, u.name,p.user_id, p.title, u.image, p.content, p.created_at,p.like_count,hide_counts,hide_comment
        FROM post p 
        JOIN user u ON u.id = p.user_id 
        WHERE p.id = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $postId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $hide_count = $row['hide_counts'];
    $hide_comment = $row['hide_comment'];
    $like_count = $row['like_count'];
    $userId = $row['user_id'];
    $title = $row['title'];
    $caption = $row['content'];
    $createdAt = $row['created_at'];
    $username = $row['name'];
    $userImage = $row['image'];
} else {
    header('Location: ./profile.php');
}


if (isset($_POST['delete'])) {

    $postId = $_POST['post_id'];

    $postId = mysqli_real_escape_string($conn, $postId);
    $postId = filter_var($postId, FILTER_VALIDATE_INT);

    $query = "DELETE FROM post WHERE id = $postId";
    $deleteResult = mysqli_query($conn, $query);

    if ($deleteResult) {
        header("Location: profile.php");
        exit();
    } else {
        // Deletion failed
        echo "Error deleting the post.";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Post - <?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>

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
    <style>
        .liked {
            color: red !important;
        }
    </style>
</head>

<body>
    <?php
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
    echo '<i class="likeButton bi bi-heart-fill heart liked" data-comment-id="' . $postId . '" style="cursor:pointer;font-size:27px"></i>';
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

    ?>
    <script src="./js/home.js"></script>
    <script>
        $(document).ready(function() {
            // Get the user ID or username, whichever is unique and identifies the user
            var userId = "<?php echo $_SESSION['userId']; ?>";

            // Retrieve liked post IDs from the local storage
            var likedPosts = JSON.parse(localStorage.getItem(userId)) || [];

            // Function to update the like count
            function updateLikeCount(commentId, button) {
                // Send an AJAX request to update the like count
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

                // Check if the comment ID is already liked
                if (likedPosts.includes(commentId)) {
                    // Remove the comment ID from liked posts
                    likedPosts = likedPosts.filter(function(postId) {
                        return postId !== commentId;
                    });

                    // Update the heart icon style
                    button.removeClass("liked");
                } else {
                    // Add the comment ID to liked posts
                    likedPosts.push(commentId);

                    // Update the heart icon style
                    button.addClass("liked");
                }

                // Update the liked post IDs in the local storage
                localStorage.setItem(userId, JSON.stringify(likedPosts));

                // Update the like count
                updateLikeCount(commentId, button);
            });

            // Load the initial like states for the user
            $(".likeButton").each(function() {
                var commentId = $(this).data("comment-id");

                // Check if the comment ID is in the liked posts array
                if (likedPosts.includes(commentId)) {
                    $(this).addClass("liked");
                } else {
                    // Set the default heart color to white for non-liked posts
                    $(this).removeClass("liked");
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

                console.log(comment);

                var postId = $(this).closest(".post-container").data("post-id");
                console.log(postId);

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
                    type: "GET",
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

</html>