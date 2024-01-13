<?php


if (isset($_COOKIE["email"]))
{
    echo "Logged in. <br>"; 
    echo "Your e-mail adress: " . $_COOKIE["email"]; 
}
else {

    //Not logged in.
    header('Location: login.php');

}


?>