<?php

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_COOKIE["email"])) {
        $type = $_POST["type"];

        switch ($type) {
            case "GetUserId":
                if (isset($_COOKIE["user_id"])) {
                    die($_COOKIE["user_id"]);
                }
                break;
            case "GetUserAvatar":
                $user_id = $_POST["id"];

                try {
                    $get_avatar_sql = "SELECT avatar FROM chat_user WHERE user_id = :userid";
                    $get_avatar_stmt = $con->prepare($get_avatar_sql);
                    $get_avatar_stmt->bindParam(':userid', $user_id);
                    $get_avatar_stmt->execute();

                    $get_avatar_results = $get_avatar_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($get_avatar_results !== false) {
                        if ($get_avatar_results["avatar"] == '') {
                            die('no-avatar.png');
                        } else {
                            die($get_avatar_results["avatar"]);
                        }
                    } else {
                        die('no-avatar.png');
                    }
                } catch (PDOException $e) {
                    die("MySql Error: " . $e->getMessage());
                }

                break;
            case "GetUserName":
                $user_id = $_POST["id"];

                try {
                    $get_avatar_sql = "SELECT username FROM chat_user WHERE user_id = :userid";
                    $get_avatar_stmt = $con->prepare($get_avatar_sql);
                    $get_avatar_stmt->bindParam(':userid', $user_id);
                    $get_avatar_stmt->execute();

                    $get_avatar_results = $get_avatar_stmt->fetch(PDO::FETCH_ASSOC);

                    if ($get_avatar_results !== false) {
                        die($get_avatar_results["username"]);
                    } else {
                        die('undefined');
                    }
                } catch (PDOException $e) {
                    die("MySql Error: " . $e->getMessage());
                }

                break;
            default:
                break;
        }
    }
}
