<?php
include_once("./db.config/db_conn.php");
session_start();
$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}
?>

<?php
include("./db.config/edit_post.inc.php");

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

    <title>Document</title>
</head>

<body>
    <nav style="position: fixed; z-index:1">
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
                    <span class="nav-item">Log out</span>
                </a></li>
            <button id="modeButton" class="mode " onclick="ChangeMode()"></button>
        </ul>
    </nav>

    <div class="new" style="padding-left:5%; padding-top:5%; position:relative">
        <div class="container add_post">
            <div class="top-post d-flex" style="flex-direction: column;">
                <a href="profile.php" class="setting-nav-back mb-3"><i class="bi bi-arrow-left"></i></a>
                <h1 class="pb-2">Edit post</h1>
                <div class="user d-flex align-items-center" style="gap: 10px;">
                    <img src="./images/<?php echo $_SESSION['image']; ?>" alt="">
                    <p><?php echo $_SESSION['name'] ?></p>
                </div>
            </div>

            <!--  -->
            <form action="edit_post.php?id=<?php echo $postId ?>" method="post" enctype="multipart/form-data">
                <div class="row pt-3">
                    <div class="image-post col-lg-5">
                        <label for="file-upload" class="custom-file-upload">
                            <img src="./images/<?php echo $title ?>" alt="Upload image" id="previewImg">
                        </label>
                        <input id="file-upload" type="file" style="display: none;" name="image" />
                        <?php
                        if (isset($_POST['submit'])) {
                            if (empty($FileName)) {
                                echo ("<div style='color:red;' class='pb-2'>Enter a photo</div>");
                            } elseif ($_FILES['image']['error'] === 4) {
                                echo ("<div style='color:red;' class='pb-2'>Something went wrong</div>");
                            } elseif (!in_array($imageExtension, $ValidImageExtension)) {
                                echo ("<div style='color:red;' class='pb-2'>Cant enter this type of image</div>");
                            } elseif ($FileSize > 1000000) {
                                echo ("<div style='color:red;' class='pb-2'>Image is too large</div>");
                            }
                        } ?>
                    </div>
                    <div class="input-post col-lg-7">
                        <?php
                        ?>
                        <textarea name="content" id="" rows="10" class="" placeholder="write a caption..." maxlength="300"><?php echo $content ?></textarea>
                    </div>
                    <div class="all-post">
                        <div class="hide-post d-flex align-items-center">
                            <label class="switch pt-2 pl-1 ml-2">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <p class="ml-3 pt-2">Hide like and view counts in this post</p>
                        </div>
                        <div class="hide-post d-flex align-items-center">
                            <label class="switch pt-2 pl-1 ml-2">
                                <input type="checkbox">
                                <span class="slider"></span>
                            </label>
                            <p class="ml-3 pt-2">Turn off commenting</p>
                        </div>
                        <button class="ml-2 mt-2 mb-5" name="submit" type="submit" style="background-color: rgb(27, 27, 255);color: white; padding: 5px;width: 90px;  border-radius: 15px;">Post</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="./js/script.js"></script>
<script src="./js/add_post.js"></script>

</html>