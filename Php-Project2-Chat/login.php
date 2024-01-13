<?php

include "connection.php";

if (isset($_COOKIE["email"])) {
    header("Location: index.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = hash('sha256', $password);

    if ($email == "" || $password == "") {

        echo "<script>
        alert('Please fill all information.');
        </script>";
    } else {
        $login_sql = "SELECT * FROM chat_user WHERE email = :email AND password = :password";

        $login_stmt = $con->prepare($login_sql);

        $login_stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $login_stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        $login_stmt->execute();

        $user_row = $login_stmt->fetch(PDO::FETCH_ASSOC);

        if ($login_stmt->rowCount() > 0) {
            $user_avatar = $user_row['avatar'];

            echo "<script>
                alert('Login successful, welcome.');
                window.location.href = 'index.php';
                </script>";

            setcookie('user_id', $user_row["user_id"], 0, '/');
            setcookie('username', $user_row["username"], 0, '/');
            setcookie('email', $email, 0, '/');
            setcookie('password', $hashed_password, 0, '/');

            if ($user_avatar == '') {
                setcookie('avatar', "no_avatar", 0, '/');
            } else {
                setcookie('avatar', $user_avatar, 0, '/');
            }
        } else {
            echo "<script>
            alert('Login failed. Username or password is wrong.');
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in now - Buddychat</title>
    <link rel="stylesheet" href="styles/login_register.css">
</head>

<body>
    <div class="container">
        <form action="#" method="post">
            <h1>Sign in now ✍️</h1>
            <p style="margin-bottom: 20px;">Log in by entering your information.</p>

            <label for="">E-mail:</label>
            <input type="email" name="email" id="" autocomplete="off">

            <label for="">Password:</label>
            <input type="password" name="password" id="" autocomplete="off">

            <button type="submit">Sign in!</button>

            <a href="register.php">Don't have an account?</a>
        </form>
    </div>
</body>

</html>