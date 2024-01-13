<?php

$host = 'localhost';
$dbname = 'php_projects';
$username = 'root';
$password = '';

try {

    $con = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e)
{
    die('Error occurred during MySql connection: ' . $e);
}

?>