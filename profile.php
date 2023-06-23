<?php
include_once("./db.config/db_conn.php");
session_start();
$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}
include("./db.config/home.inc.php");

if (isset($_SESSION['password_change']) && $_SESSION['password_change']) {
    echo '<script>
        setTimeout(function() {
            Swal.fire({
                icon: "success",
                title: "Password successfully changed!",
                showConfirmButton: false,
                timer: 2000
            });
        }, 100);
    </script>';
    $_SESSION['password_change'] = false;
}


$post_count_query = "Select count(*) as total from post where user_id = " . $_SESSION['userId'] . ""; // 3
$result = mysqli_query($conn, $post_count_query);
$data = mysqli_fetch_assoc($result);
$post_counts = $data['total'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/home.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Document</title>
</head>

<body>

    <img src="./images/644a." alt="">
    <nav style="position: fixed;">
        <ul>
            <li class="pb-5 mb-5">
                <a href="./profile.php">
                    <img src="./images/<?php echo $_SESSION['image'];
                                        ?>" alt="<?php echo $_SESSION["name"] ?>">
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
                    <span class="nav-item">Log out</span>
                </a></li>
            <button id="modeButton" class="mode " onclick="ChangeMode()"></button>

        </ul>
    </nav>

    <div class="profile">
        <div class="name-email pt-3 mt-5">
            <p class=""><?php echo $_SESSION['name'] ?></p>
            <!-- <p style="opacity: 0.3;"><?php echo $_SESSION['date'] ?></p> -->
            <p class=""><?php echo ($_SESSION['email']) ?></p>
        </div>
        <div class="profile-data  pt-3 mt-5">
            <div>
                <img src="./images/<?php echo $_SESSION['image'] ?>" alt="" style="">
            </div>
            <div class="profile-info">
                <div class="fol pb-4">
                    <div class="text-center px-2"><?= $post_counts ?><br>Posts</div>
                    <div class="text-center">0<br>Followers</div>
                    <div class="text-center">0<br>Following</div>
                </div>
                <div class="desc mb-5">
                    <p style="  word-wrap: break-word;
"><?php echo $_SESSION['desc'] ?></p>
                </div>
                <div class="edit-profile ">
                    <button class="edit-button"><a href="setting.php" style="color: white;">edit profile</a></button>
                </div>
            </div>
        </div>

        <?php
        $userId = $_SESSION['userId'];
        $sql = "SELECT p.id, u.name, p.title, u.image, p.content, p.created_at 
        FROM post p 
        JOIN user u ON u.id = p.user_id 
        where u.id =$userId
        ORDER BY p.created_at DESC";
        $result = mysqli_query($conn, $sql);

        ?>


        <div class="container post-profile pt-4 d-flex" style="flex-wrap: wrap;justify-content:center;gap:3px">
            <?php while ($row = mysqli_fetch_assoc($result)) {
                $postid = $row['id'];
            ?>
                <div class="profile-post" ">
                    <div class=" post-image">
                    <a href="post.php?post_id=<?php echo $postid; ?>" class="card-link"><img src="./images/<?php echo $row['title'] ?>" style="padding: 5px;" alt=""></a>
                </div>
        </div>
    <?php }
    ?>
    </div>

    <?php
    if (mysqli_num_rows($result) < 1) {
        echo '
<div class="share d-flex justify-content-center align-items-center">
    <div class="image-share text-center pt-5">
        <i class="bi bi-camera text-center" style="border:1px solid rgb(85, 83, 83);border-radius:100%;width:200px;height:20px;padding:5px 10px 5px 10px;"></i>
        <h1 class="mt-4">share photos</h1>
        <h6 class="pb-3">When you share photo they will appear on your profile</h6>
        <div class="edit-profile">
            <a href="add_post.php" class="edit-button" style="color:white;background-color: rgb(85, 83, 83);width:200px;padding:10px;border-radius:30px;">Share your first photo</a>
        </div>
    </div>
</div>';
    }
    ?>
    </div>
    </div>

</body>
<script src="./js/script.js"></script>

</html>