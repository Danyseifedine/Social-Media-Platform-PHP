<?php

// Including database connection file
include("db_conn.php");

// Checking if the form is submitted
if (isset($_POST["submit"])) {

    // Storing email and password values from the form
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Query to check if the email exists in the database
    $checkEmail = "SELECT * FROM user WHERE email = '$email' AND name IS NOT NULL";

    // Executing the query and getting the result
    $checkEmail_result = mysqli_query($conn, $checkEmail);

    // Fetching the user details from the result
    $user = mysqli_fetch_assoc($checkEmail_result);

    // If a user is found with the given email
    if ($user) {


        if ($user['status'] == 'deactivated') {
            header("location:./deactivated.php");
            exit();
        }



        // Checking if the password matches the hashed password stored in the database
        if (password_verify($password, $user['password'])) {

            // Starting the session and storing user details in the session variables
            session_start();
            $_SESSION['image'] = $user['image'];
            $_SESSION['userId'] = $user['id'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['date'] = $user['date'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['desc'] = $user['description'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['country'] = $user['country'];
            $_SESSION["logged_in"] = 'true';

            // Redirecting the user to the home page

            header("location:home.php");
            die();
        }

        // If the password doesn't match
        elseif (!password_verify($password, $user['password'])) {
            // echo ("<div class = 'error'>wrong password</div>");
        }
    }

    // If a user is not found with the given email
    else {
        // echo ("<div class = 'error'>account doesnt exist</div>");
    }
}
