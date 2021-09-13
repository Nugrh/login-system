<?php

session_start();

if (isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}


require 'function.php';
global $conn;

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}




$sql = "SELECT * FROM `users`";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$hash = $row['password'];

if (isset($_POST["submit"])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    if (mysqli_num_rows($result)){

        if ($row["email"] == $email && password_verify($password, $hash)){

            header("Location: index.php");
            $_SESSION["login"] = true;

            die();
        } else{
            echo "Email or password not found! please try again";
        }
    } else {
        echo "nothing";
    }


} else {
    echo mysqli_error($conn);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
<form action="" method="post">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember-me" name="remember-me">
        <label class="form-check-label" for="remember-me">Check me out</label>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

</body>
</html>
