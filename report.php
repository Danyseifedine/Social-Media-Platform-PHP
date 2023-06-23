<?php
include_once("./db.config/db_conn.php");
session_start();

$user = $_SESSION['logged_in'];
if (!isset($user)) {
    header("location:login.php");
}

include_once("./db.config/report.inc.php");
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


    <title>Document</title>
</head>

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
                    <span class="nav-item">Log out</span>
                </a></li>
            <button id="modeButton" class="mode " onclick="ChangeMode()"></button>

        </ul>
    </nav>

    <div class="report pt-5">
        <div class="container">
            <div class="report_user pl-5" style="border-left: 1px solid rgba(88, 88, 88, 0.583);">
                <form action="report.php?id=<?php echo $_GET['id']; ?>" class="d-flex justify-content-center" method="POST" style="flex-direction:column;gap:10px;">
                    <div>
                        <label for="reason">Reason for Report:</label>
                        <select name="reason" id="reason">
                            <option value="inappropriate">Inappropriate Content</option>
                            <option value="spam">Spam</option>
                            <option value="harassment">Harassment</option>
                            <option value="violence">Violence</option>
                        </select>
                    </div>
                    <div class="textarea d-flex align-items-center">
                        <label for="details">Details:</label>
                        <textarea class="ml-5" name="details" id="details" rows="5" style="border-radius: 10px; height: 300px;max-height: 300px; width: 360px;"></textarea>
                    </div>
                    <div class="input">
                        <label for="name">Your Name:</label>
                        <input class="ml-3" type="text" name="name" id="name" style="padding: 5px;border-bottom: 1px solid #6C63FF; border-radius: 5px;" value="<?php echo $_SESSION['name'] ?>" readonly>
                    </div>
                    <div class="input">
                        <label for="email">Your Email:</label>
                        <input type="email" name="email" id="email" style="padding: 5px !important;border-bottom: 1px solid #6C63FF !important;margin-left:20px; border-radius: 5px !important;" value="<?php echo $_SESSION['email'] ?>" readonly>
                    </div>
                    <button class="mt-3" name="submit" type="submit" style="background-color: rgb(27, 27, 255);color: white;padding: 5px;width: 100px;border-radius: 15px;margin-left:100px">Report</button>
                </form>

            </div>
        </div>
    </div>
</body>
<script src=" ./js/script.js"></script>

</html>