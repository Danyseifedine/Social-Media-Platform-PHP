<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,400;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    @font-face {
        font-family: "Poppins-Medium";
        src: url('../assets/fonts/Poppins-Medium.ttf');
    }

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none !important;
        font-family: "Poppins-Medium";
    }
</style>

<body>

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'This account is permanently deactivated',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "login.php";
            }
        })
    </script>
</body>


</html>