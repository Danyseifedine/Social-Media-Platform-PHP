<!-- registration logic -->
<?php
include("db_conn.php");

if (isset($_POST["submit"])) {

    // creating new variable by their name in the input field
    $fullname = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeatpassword"];

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

    $error = array();

    // checking if the email already exists or not 
    $checkEmail = "SELECT * FROM user WHERE email = '$email'";
    $checkEmail_result = mysqli_query($conn, $checkEmail);
    $rowCount = mysqli_num_rows($checkEmail_result);
    if ($rowCount > 0) {
        $error["email"] = "Email is already in use";
    }

    // checking if the name or email or password or the repeated password are not empty
    elseif (empty($fullname) || empty($email) || empty($password) || empty($repeatpassword)) {
        array_push($error, "All fields are required");
    }

    // checking if the user is writing the email with all the important details
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($error, "Email is not valid");
    }

    // checking that the password must not be less than 5 characters
    elseif (strlen($password) < 5) {
        array_push($error, "Password too short");
    }

    // checking if the password is the same in the repeat password field
    elseif ($password !== $repeatpassword) {
        array_push($error, "Passwords do not match");
    }

    // Verifying if the entered name and password conform to the specified pattern.
    elseif (!preg_match('/^[a-zA-Z0-9_-]+$/', $fullname) || !preg_match('/^[a-zA-Z0-9_\-\p{P}]+$/', $password)) {
        array_push($error, "Invalid password or name");
    }

    // checking if the length of the name is greater than 15 characters
    elseif (strlen($fullname) > 15) {
        array_push($error, "Name must be less than 15 characters");
    }

    // checking for errors related to the image upload
    elseif ($_FILES['image']['error'] === 4) {
        array_push($error, "Error while selecting an image");
    } elseif (!in_array($imageExtension, $ValidImageExtension)) {
        array_push($error, "Wrong type of image");
    } elseif ($FileSize > 1000000) {
        array_push($error, "File too large");
    } elseif (empty($FileName)) {
        array_push($error, "Add image");
    } else {
        try {
            // Generate unique image name
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            // Move uploaded file to "images" folder with new name
            move_uploaded_file($FileTmp, 'images/' . $newImageName);

            // Hash the password
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);

            // Insert user data into database
            $sql = "INSERT INTO user (name, email, password, image, date) VALUES (?, ?, ?, ?, NOW())";
            $stmt = mysqli_stmt_init($conn);
            $prepare = mysqli_stmt_prepare($stmt, $sql);

            if ($prepare) {
                mysqli_stmt_bind_param($stmt, "ssss", $fullname, $email, $password_hashed, $newImageName);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Record inserted successfully.";
                    header("location:login.php");


                } else {
                    echo "Error executing statement: " . mysqli_stmt_error($stmt);
                }
            } else {
                echo "Error preparing statement: " . mysqli_error($conn);
            }
        } catch (\Exception $ex) {
            // If any exception occurred, show the error message
            echo "Error exception: " . $ex;
        }
    }
}
