 <?php
    include("db_conn.php");

    use FFI\Exception;

    session_start();

    if (isset($_POST['submit'])) {

        $sessionId = $_SESSION['userId'];
        $new_password = $_POST['new_password'];
        $old_password = $_POST['old_password'];
        $confirm_password = $_POST['confirm_password'];

        $getuser = "SELECT * FROM user WHERE id = '$sessionId' LIMIT 1";
        $getuser_result = mysqli_query($conn, $getuser);
        $user = mysqli_fetch_assoc($getuser_result);

        if (!password_verify($old_password, $user['password'])) {
            header("location:../Change-password.php");
            exit;
        } elseif (empty($new_password) || empty($old_password) || empty($confirm_password)) {
            header("location:../Change-password.php");
            exit;
        } elseif ($confirm_password !== $new_password) {
            header("location:../Change-password.php");
            exit;
        } elseif (!preg_match('/^[a-zA-Z0-9_\-\p{P}]+$/', $new_password)) {
            header("location:../Change-password.php");
            exit;
        } elseif (strlen($new_password) < 5) {
            header("location:../Change-password.php");
            exit;
        } else {
            $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $new_password = $_SESSION['password'];
            $sql = "UPDATE user SET password = '$new_password_hash' WHERE id = '$sessionId'";
            if (mysqli_query($conn, $sql)) {

                $_SESSION['password_change'] = "true";
                header("location:../profile.php");
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        }
    }
