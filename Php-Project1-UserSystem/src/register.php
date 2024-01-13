<?php

include "../connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{


    $username = $_POST["username"];
    $password = $_POST["password"];
    $againpassword = $_POST["againpassword"];
    $email = $_POST["email"];

    if ($username != "" && $password != "" && $againpassword != "" && $email != "") { 

        if ($password != $againpassword) { 

            echo "<script> 
            alert('Passwords do not match.');
            </script>";

            exit;

        }

        $hashed_password = hash('sha256', $password); 

        $email_check_sql = "SELECT * FROM mysql_user WHERE email = :email"; 

        $email_check_stmt = $con->prepare($email_check_sql); 

        $email_check_stmt->bindParam(':email', $email); 

        $email_check_stmt->execute(); 

        if ($email_check_stmt->rowCount() > 0) 
        {

            echo "<script>
            alert('There is already an account opened with this email.');
            </script>"; 

            exit; 

        }

        try {

            $register_sql = "INSERT INTO mysql_user (username, email, password) VALUES (:username, :email, :password)";

            $register_stmt = $con->prepare($register_sql);
    
            $register_stmt->bindParam(':username', $username);
            $register_stmt->bindParam(':email', $email);
            $register_stmt->bindParam(':password', $hashed_password);
    
            $register_stmt->execute();

            echo "<script> 
        alert('Registration successful, welcome!');
        </script>";

        }
        catch (PDOException $e)
        {
            echo "<script> 
        alert('An error occurred during the registration process. Please try again.');
        </script>";

        exit;
        }
        

    } else {

        echo "<script> 
        alert('Please fill in all information.');
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
    <title>Please Register</title>

    <style>
        form {
            display: flex;
            flex-direction: column;

            width: max-content;

        }

        input {
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 3px;
        }
    </style>
</head>

<body>
    <form action="#" method="post">
        <label for="">Username:</label>
        <input type="text" name="username" id="">

        <label for="">Email:</label>
        <input type="email" name="email" id="">

        <label for="">Password:</label>
        <input type="password" name="password" id="">

        <label for="">Again Password:</label>
        <input type="password" name="againpassword" id="">

        <button type="submit">Sign up now</button>
    </form>
</body>

</html>