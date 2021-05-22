<?php
//This script will handle login
session_start();

// check if the user is already logged in
if(isset($_SESSION['username']))
{
    header("location: loggedin.php");
    exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: loggedin.php");
                            
                        }
                    }

                }

    }
}    


}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="logo.jpeg" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="loginPage.css">
    <title>Attendo</title>
</head>

<body class="text-center">
    <div class="container d1 my-5 text-light">
        <form class="form-signin" action="" method="post">
            <a href="mainPage.html"><img src=" logo.jpeg" alt=""></a>
            <div class="form-group d2">
                <label for="formGroupExampleInput2">Username</label>
                <input type="text" name="username" class="form-control text-light bg-dark inputs"
                    id="formGroupExampleInput2">
                <small id="emailHelp" class="form-text">Enter valid username</small>
            </div>
            <div class="form-group d2">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control bg-dark text-light inputs" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-dark">Sign In</button>
            <p style="margin-top: 1rem; font-size: small;">Not yet a member? <a href="signupPage.php">Sign Up</a></p>
        </form>
    </div>
</body>

</html>