<?php
include_once("./db.config/db_conn.php");
session_start();
$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}


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
    <nav style="position: fixed;z-index: 1">
        <ul>
            <li class="pb-5 mb-5">
                <a href="./profile.php">
                    <img src="./images/<?php echo $_SESSION['image'];
                                        ?>" alt="">
                    <span class="nav-item"><?php
                                            echo      $_SESSION['name'] ?></span>
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
    <div class="setting mt-3 pb-1">
        <div class="setting-header">
            <div class="setting-nav">
                <a href="profile.php" class="setting-nav-back"><i class="bi bi-arrow-left"></i></a>
                <h1 class="pt-5">Settings</h1>
                <div class="d-flex" style="flex-direction: column; gap:10px;">
                    <a href="setting.php">Edit profile</a>
                    <a href="Change-password.php">Change password</a>
                    <form action="./db.config/setting.inc.php" method="post" onsubmit="return confirm('Are you sure you want to deactivate your account?')">
                        <input type="submit" name="deactivate" value="Deactivate Account" style="background-color: transparent; color:#007bff">
                    </form>
                </div>

            </div>
            <form action="./db.config/change-pass.inc.php" method="post">
                <div class=" edit-profile">
                    <div class="user">
                        <img src="./images/<?php echo $_SESSION['image'] ?>" alt="">
                        <div>
                            <p class="mb-0 mt-4"><?php echo $_SESSION['name'] ?></p>
                        </div>
                    </div>
                    <p class="mb-0 mt-4 mb-4" style="opacity: 0.7; color:rgb(83,83,83)"><?php echo $_SESSION['date']; ?></p>
                    <div class="name-change d-flex align-center">
                        <label for="name" style="padding-right: 40px;">Old password </label>
                        <input type="password" name="old_password">
                    </div>
                    <p style="width:420px; font-size:13px;text-align:justify; color:rgb(85, 83, 83);" class="image-error pt-4"><span style="opacity: 0.8;"> Make sure that you enter your <span style="color: red;opacity:0.9 !important;">correct old password</span></span< /p>
                            <div class="name-change pt-4 d-flex align-center">
                                <label for="name" style="padding-right: 35px;">New password </label>
                                <input type="password" name="new_password">
                            </div>
                            <p style="width:420px; font-size:13px;text-align:justify; color:rgb(85, 83, 83);" class="image-error pt-4"><span style="opacity: 0.8;">To ensure the security of your account, we kindly ask that your password</span><span style="color: red;opacity:0.9 !important;"> be at least 5 characters long</span>. Please note that <span style="color: red;opacity:0.9 !important;">symbols, dashes, and underscores are accepted </span>. Thank you for your cooperation</p>
                            <div class="name-change pt-4 d-flex align-center">
                                <label for="name" style="padding-right: 10px;">Confirm password </label>
                                <input type="password" name="confirm_password">
                            </div>
                            <p style="width:420px; font-size:13px;text-align:justify; color:rgb(85, 83, 83);" class="image-error pt-4"><span style="opacity: 0.8;">"Upon changing your password, a pop-up message will confirm the update. If you don't see the message, please double-check that your old and new passwords meet the minimum requirements.</p>
                            <div class="name-change pt-4 d-flex align-center">
                                <button type="submit" name="submit" class="mt-5">submit</button>
                            </div>
                </div>
            </form>
        </div>
        <script src="./js/script.js"></script>
        </nav>