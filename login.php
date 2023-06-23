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
    <title>Document</title>
</head>

<body>
    <?php
    include_once("/laragon/www/university/full_project/db.config/login.inc.php");
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
        <div class="inputs">
            <form action="login.php" method="post">
                <h1>Log in</h1>

                <?php

                include("/laragon/www/university/full_project/db.config/login.inc.php");




                if (isset($_POST["submit"])) {

                    if ($email !== 1) {
                        echo ("<div class='error' style='color:red !important;'>email invalid</div>");
                    }
                }
                ?>
                <div class="inputbox">
                    <i class="bi bi-envelope-fill"></i>
                    <input type="email" name="email" placeholder="Email..." id="email">
                </div>

                <div class="inputbox">
                    <i class="bi bi-shield-lock-fill"></i>
                    <input type="password" name="password" placeholder="Password..." id="password">
                </div>

                <div class="inputbox">
                    <i class="bi bi-arrow-right"></i>
                    <input type="submit" name="submit" style="cursor: pointer;">
                </div>
                <a href="./register.php" style="text-decoration: none; padding-top:10px; color:#6C63FF;"><span style="text-decoration: none; color:black; ">Dont have an account?</span> sign up</a>
                <pre style="font-size: 12px;">account for test: test@gmail.com</pre>
                <pre style="font-size: 12px;">password for test: testtest</pre>
            </form>
        </div>
        <div id="anime2">
            <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
            <lottie-player src="https://assets9.lottiefiles.com/private_files/lf30_fw6h59eu.json" background="transparent" speed="1" style="max-width: 100%; max-height: 100%;" loop autoplay></lottie-player>
        </div>
    </body>
    <script src="./js/script.js"></script>

    </html>
</body>

</html>