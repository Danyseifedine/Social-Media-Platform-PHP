<?php

use FFI\Exception;

include_once("db_conn.php");
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("location:login.php");
    exit();
}
if (isset($_POST['deactivate'])) {

    $user_id = $_SESSION['userId'];
    $sql = "UPDATE user SET status = 'deactivated' WHERE id = '$user_id'";
    mysqli_query($conn, $sql);

    session_destroy();

    header("Location:../logout.php");
    exit;
}


if (isset($_POST['submit'])) {

    $description = $_POST["description"];
    $phone = $_POST["phone"];
    $NewName = $_POST['name'];
    $country = $_POST['country'];
    $sessionId = $_SESSION['userId'];
    $image = $_FILES['image'];

    $FileName = $_FILES['image']['name'];
    $FileSize = $_FILES['image']['size'];
    $FileType = $_FILES['image']['type'];
    $FileTmp = $_FILES['image']['tmp_name'];

    $ValidImageExtension = ['jpg', 'jpeg', 'png'];

    $imageExtension = explode('.', $FileName);
    $imageExtension = strtolower(end($imageExtension));

    if ($FileSize <= 0 && empty($FileName) && empty($FileType) && empty($FileTmp)) {
        $newImageName = $_SESSION['image'];
    } else {
        if (!in_array($imageExtension, $ValidImageExtension)) {
            // array_push($error, "Wrong type of image");
            header("location:../setting.php");
            die();
        } elseif ($FileSize > 1000000) {
            header("location:../setting.php");
            array_push($error, "File too large");
            die();
        } else {
            // Generate unique image name
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            // Move uploaded file to "images" folder with new name
            move_uploaded_file($FileTmp, '../images/' . $newImageName);
        }
    }

    $error = array();

    if (strlen($NewName) > 15 || strlen($NewName) < 4) {
        $error['name'] = 'Name must be between 4 and 15 characters long';
        header("location:../setting.php");
    } elseif (!preg_match('/^[a-zA-Z0-9_\-]+$/', $NewName)) {
        array_push($error, "Invalid name");
        header("location:../setting.php");
    } elseif (strlen($description) >= 150) {
        $error['description'] = 'Description must be less than 150 characters long';
        header("location:../setting.php");
    } elseif (!empty($description) && !preg_match('/^[a-zA-Z0-9_\s-]+$/', $description)) {
        $error['description'] = 'Invalid description';
        header("location:../setting.php");
    } elseif (!empty($phone) && !preg_match('/^[0-9\s]+$/', $phone)) {
        header("location:../setting.php");
        echo "Invalid phone number";
    } else {

        $query = "UPDATE user SET name ='$NewName', description = '$description' , phone='$phone' , image = '$newImageName' , country='$country'  WHERE id =$sessionId";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            echo "Error: " . mysqli_error($conn);
            exit();
        } else {
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $NewName;
            $_SESSION['desc'] = $description;
            $_SESSION['image'] = $newImageName;
            $_SESSION['country'] = $country;
            header("location:../profile.php");
            exit();
        }
    }
}
