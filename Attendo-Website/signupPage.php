<?php
require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
}
else{
    $password = trim($_POST['password']);
}



// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: loginPage.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
</head>

<body>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" href="logo.jpeg" />
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="signupPage.css">
        <title>Attendo</title>
    </head>

    <body class="text-center">
        <div class="container d1 text-light">
            <form class="form-signin" method="post" action="">
                <a href="mainPage.html"><img src=" logo.jpeg" alt=""></a>
                <div class="form-group d2">
                    <label for="formGroupExampleInput2">Set Username</label>
                    <input placeholder="Firstname Lastname" type="text" name="username" class="form-control text-light bg-dark inputs"
                        id="formGroupExampleInput2">
                    <small id="emailHelp" class="form-text">Enter a username</small>
                </div>
                <div class="form-group d2">
                    <label for="exampleInputPassword1">Set Password</label>
                    <input type="password" name="password" class="form-control bg-dark text-light inputs" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-dark">Sign Up</button>
                <p style="margin-top: 1rem; font-size: small;">Already a member? <a href="loginPage.php">Login</a>
                </p>
            </form>
        </div>
    </body>

    </html>
</body>

</html>