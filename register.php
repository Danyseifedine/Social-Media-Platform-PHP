<?php
include_once("/laragon/www/university/full_project/db.config/register.inc.php");
?>
<?php
session_start();

if (isset($_SESSION['logged_in'])) {
    header("location:home.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <title>Document</title>
</head>

<body>
    <div id="anime">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="https://assets7.lottiefiles.com/packages/lf20_nc1bp7st.json" background="transparent" speed="1" style=" max-height: 100%;" loop autoplay></lottie-player>
    </div>
    <div class="inputs">
        <form action="register.php" method="post" enctype="multipart/form-data">
            <h1>Sign up</h1>
            <?php
            if (isset($_POST["submit"])) {

                if (empty($fullname)) {
                    echo ('<div class="error" style="color:red !important;">You must enter your full name</div>');
                } elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $fullname)) {
                    echo ('<div class="error" style="color:red !important;">Name can only contain letters and numbers</div>');
                } elseif (strlen($fullname) > 255) {
                    echo ('<div class="error" style="color:red !important;>Name must be at less than 255 characters</div>');
                }
            }
            ?>
            <div class="inputbox">
                <i class="bi bi-person-fill"></i>
                <input type="text" name="name" placeholder="Name..." id="name">
            </div>
            <?php

            include("/laragon/www/university/full_project/db.config/register.inc.php");


            if (isset($_POST["submit"])) {

                if (empty($email)) {
                    echo ("<div class='error' style='color:red !important;'>You must enter your email</div>");
                } elseif ($rowCount > 0) {
                    echo ("<div class='error' style='color:red !important;'>Email already exist </div>");
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo ('<div class="error" style="color:red !important;">Email invalid</div>');
                }
            }
            ?>
            <div class="inputbox">
                <i class="bi bi-envelope-fill"></i>
                <input type="email" name="email" placeholder="Email..." id="email">
            </div>
            <?php
            if (isset($_POST["submit"])) {

                if (empty($password)) {
                    echo ("<div class='error' style='color:red !important;'>You must enter your password</div>");
                } elseif (!preg_match('/^[a-zA-Z0-9_\-\p{P}]+$/', $password)) {
                    echo ('<div class="error" style="color:red !important;">Password can only contain letters and numbers</div>');
                } elseif (strlen($password) < 5) {
                    echo ('<div class="error" style="color:red !important;">password is too short</div>');
                }
            }
            ?>
            <div class="inputbox">
                <i class="bi bi-shield-lock-fill"></i>
                <input type="password" name="password" placeholder="Password..." id="password">
            </div>
            <?php
            if (isset($_POST["submit"])) {

                if (empty($repeatpassword)) {
                    echo ("<div class='error' style='color:red !important;'>Confirm your password</div>");
                } elseif ($repeatpassword !== $password) {
                    echo ('<div class="error" style="color:red !important;">Passwords do not match</div>');
                }
            }
            ?>
            <div class="inputbox">
                <i class="bi bi-file-check"></i>
                <input type="password" name="repeatpassword" placeholder="Confirm password...">
            </div>
            <?php
            if (isset($_POST["submit"])) {

                $FileName = $_FILES['image']['name'];
                $FileSize = $_FILES['image']['size'];
                $FileType = $_FILES['image']['type'];
                $FileTmp = $_FILES['image']['tmp_name'];

                $ValidImageExtension = ['jpg', 'jpeg', 'png'];
                $imageExtension = explode('.', $FileName);
                $imageExtension = strtolower(end($imageExtension));

                if (empty($FileName)) {
                    echo ("<div class='error' style='color:red !important;'>Add image</div>");
                } elseif ($FileSize > 1000000) {
                    echo ("<div class='error' style='color:red !important;'>Image is too large</div>");
                } elseif (!in_array($imageExtension, $ValidImageExtension)) {
                    echo ('<div class="error" style="color:red !important;">you cant enter this type of images</div>');
                }
            }
            ?>
            <div class="inputbox" id="image">
                <i class="bi bi-person-bounding-box"></i>
                <input type="file" name="image" id="input-file" style="display: none;" accept="image/*">
                <label class="inputbox" for="input-file" style="border: 1px solid grey;padding: 10px 10px 10px 10px; cursor:pointer">Profile Image</label>
            </div>
            <div class="inputbox">
                <i class="bi bi-arrow-right"></i>
                <input type="submit" name="submit" style="cursor: pointer;">
            </div>
            <a href="./login.php" style="text-decoration: none; padding-top:10px; color:#6C63FF;"><span style="text-decoration: none; color:black; ">Have an account?</span> log in</a>
        </form>

    </div>

</body>
<script src="./js/main.js"></script>

</html>