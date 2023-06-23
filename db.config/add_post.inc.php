<?php

include("db_conn.php");

// Checking if the form is submitted
if (isset($_POST["submit"])) {

    if (isset($_POST["hide_counts"])) {

        $hideCounts = 0;
    } else {
        $hideCounts = 1;
    }

    if (isset($_POST["hide_comment"])) {

        $hideComment = 0;
    } else {
        $hideComment = 1;
    }

    $sessionUser = $_SESSION['userId'];
    // Storing email and password values from the form
    $caption = $_POST["caption-post"];

    $checkEmail = "SELECT * FROM user where id = $sessionUser";

    // Executing the query and getting the result
    $checkEmail_result = mysqli_query($conn, $checkEmail);

    // Fetching the user details from the result
    $user = mysqli_fetch_assoc($checkEmail_result);


    $userid = $user['id'];

    // calling all elements of the file array and put them into a variable
    $FileName = $_FILES['image']['name'];
    $FileSize = $_FILES['image']['size'];
    $FileType = $_FILES['image']['type'];
    $FileTmp = $_FILES['image']['tmp_name'];

    // adding the usable types of an image into an array
    $ValidImageExtension = ['jpg', 'jpeg', 'png'];

    // dividing the name into name + type using explode; it returns an array
    $imageExtension = explode('.', $FileName);
    $imageExtension = strtolower(end($imageExtension));

    if (empty($FileName)) {
        $error = "Please add a caption";
    } elseif ($_FILES['image']['error'] === 4) {
        $error = "Please add a caption";
    } elseif (!in_array($imageExtension, $ValidImageExtension)) {
        $error = "Please add a caption";
    } elseif ($FileSize > 1000000) {
        $error = "Please add a caption";
    } else {

        // Generate unique image name
        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        // Move uploaded file to "images" folder with new name
        move_uploaded_file($FileTmp, 'images/' . $newImageName);

        // Hash the password

        // Insert user data into database
        $sql = "INSERT INTO post (user_id, title, content, hide_counts,hide_comment, created_at) VALUES ('$userid', '$newImageName', '$caption', '$hideCounts','$hideComment', NOW())";

        // Executing the query and getting the result
        $checkEmail_result = mysqli_query($conn, $sql);

        header("location:/full_project/profile.php");
    }
}
