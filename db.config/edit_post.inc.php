<?php

include("db_conn.php");

$id = $_GET["id"];


if (empty($id)) {
    header("location:profile.php");
}


$sql = "SELECT p.id, u.name,updated_at, p.title,p.user_id, u.image, p.content, p.created_at 
FROM post p 
JOIN user u ON u.id = p.user_id 
where p.id = $id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {


    $row = mysqli_fetch_array($result);

    $postId = $row['id'];
    $user_id = $row["user_id"];
    $name = $row["name"];
    $title = $row["title"];
    $content = $row["content"];
}

if (isset($_POST['submit'])) {

    $FileName = $_FILES['image']['name'];
    $FileSize = $_FILES['image']['size'];
    $FileType = $_FILES['image']['type'];
    $FileTmp = $_FILES['image']['tmp_name'];

    $content = $_POST['content'];

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

        $newImageName = uniqid();
        $newImageName .= '.' . $imageExtension;

        if (empty($newImageName)) {
        }

        // Move uploaded file to "images" folder with new name
        move_uploaded_file($FileTmp, 'images/' . $newImageName);
        $sql = "UPDATE post p SET p.title = '$newImageName', p.content = '$content' , updated_at = NOW() WHERE p.id = $id";
        $result = mysqli_query($conn, $sql);
        header("location:profile.php");
    }
}
