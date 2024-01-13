<?php

include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = hash('sha256', $password);

    if ($email == "" || $password == "")
    {

        echo "<script>
        alert('Please fill all information.');
        </script>";

        exit;
    }

    $login_sql = "SELECT * FROM mysql_user WHERE email = :email";

    $login_stmt = $con->prepare($login_sql);

    $login_stmt->bindParam(':email', $email);

    $login_stmt->execute();

    $user = $login_stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $hashed_password == $user['password'])
    {
        echo "<script>
        alert('Login successful, welcome.');
        </script>";

        setcookie('email', $email, 0, '/');
        setcookie('password', $hashed_password, 0, '/');
        
    }
    else {
        echo "<script>
        alert('Login failed. Username or password is wrong.');
        </script>";
        
        exit;

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Please Login</title>
</head>
<body>
    <form action="#" method="post">
        <label for="">E-mail:</label>
        <input type="email" name="email" id="">

        <label for="">Password:</label>
        <input type="password" name="password" id="">

        <button type="submit">Sign in now</button>
    </form>
</body>
</html>