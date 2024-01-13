<?php

include "connection.php";

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
        }
        else {
            $hashed_password = hash('sha256', $password); 

            $email_check_sql = "SELECT * FROM chat_user WHERE email = :email"; 
    
            $email_check_stmt = $con->prepare($email_check_sql); 
    
            $email_check_stmt->bindParam(':email', $email); 
    
            $email_check_stmt->execute(); 
    
            if ($email_check_stmt->rowCount() > 0) 
            {
    
                echo "<script>
                alert('There is already an account opened with this email.');
                </script>";     
            }
            else {
                try {
    
                    $register_sql = "INSERT INTO chat_user (username, email, password) VALUES (:username, :email, :password)";
        
                    $register_stmt = $con->prepare($register_sql);
            
                    $register_stmt->bindParam(':username', $username);
                    $register_stmt->bindParam(':email', $email);
                    $register_stmt->bindParam(':password', $hashed_password);
            
                    $register_stmt->execute();
        
                    echo "<script> 
                alert('Registration successful, welcome!');
                window.location.href='login.php';
                </script>";
        
                }
                catch (PDOException $e)
                {
                    echo "<script> 
                alert('An error occurred during the registration process. Please try again.');
                </script>";
        
                
                }
            }
        }

        
        

    } else {

        echo "<script> 
        alert('Please fill in all information.');
        </script>";

        

    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up now - Buddychat</title>
    <link rel="stylesheet" href="styles/login_register.css">
</head>
<body>
    <div class="container">
        <form action="#" method="post">
            <h1>Sign up now 👋</h1>
            <p style="margin-bottom: 20px;">Sign up by entering your information.
</p>

            <label for="">Username:</label>
            <input type="text" name="username" id="" autocomplete="off">

            <label for="">E-mail:</label>
            <input type="email" name="email" id="" autocomplete="off">

            <label for="">Password:</label>
            <input type="password" name="password" id="" autocomplete="off">

            <label for="">Again Password:</label>
            <input type="password" name="againpassword" id="" autocomplete="off">

            <button type="submit">Sign up!</button>

            <a href="login.php">Do you have an account?</a>
        </form>
    </div>
</body>
</html>