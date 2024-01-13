<?php

$host = 'localhost';
$dbname = 'php_projects';
$user = 'root';
$password = '';


try { 

    $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    
   
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) { 
    
    die("An error occurred during MYSQL connection: " . $e);
}
