<?php
$host = "localhost";
$db = "uni_blog";
$user = "root";
$password = "";

try {
    $conn = mysqli_connect($host, $user, $password, $db);
    // echo("done");
} catch (Exception $e) {
    // echo("Error:" . $e);
}
