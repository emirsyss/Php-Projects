<?php

include "connection.php";

if (!isset($_COOKIE["email"])) {
    header("Location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = $_POST["type"];
    $user_id = $_COOKIE["user_id"];

    switch ($type) {
        case "update_avatar":
            if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == UPLOAD_ERR_OK) {
                $allowedTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

                if (in_array($_FILES["avatar"]["type"], $allowedTypes)) {
                    $uploadDir = "assets/avatars/";

                    $fileInfo = pathinfo($_FILES["avatar"]["name"]);
                    $extension = strtolower($fileInfo['extension']);

                    $newFileName = $user_id . '.' . $extension;
                    $uploadFile = $uploadDir . $newFileName;

                    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $uploadFile)) {

                        try {
                            $update_avatar_sql = "UPDATE chat_user SET avatar = :avatar WHERE user_id = :user_id";
                            $update_avatar_stmt = $con->prepare($update_avatar_sql);
                            $update_avatar_stmt->bindParam(':avatar', $newFileName);
                            $update_avatar_stmt->bindParam(':user_id', $user_id);
                            $update_avatar_stmt->execute();
                        } catch (PDOException $e) {
                            die('MySql Error: ' . $e->getMessage());
                        }

                        setcookie('avatar', $newFileName, 0, '/');
                        die('Avatar update successful.');
                    } else {
                        die('Avatar update failed.');
                    }
                } else {
                    die('Invalid file type. Only PNG, JPG, JPEG and GIF files are accepted.');
                }
            } else {
                die('File upload error.');
            }
            break;
        case "update_username":
            $new_username = $_POST["username"];

            if ($new_username != "") {
                try {
                    $update_username_sql = "UPDATE chat_user SET username = :new_username WHERE user_id = :user_id";
                    $update_username_stmt = $con->prepare($update_username_sql);
                    $update_username_stmt->bindParam(':new_username', $new_username);
                    $update_username_stmt->bindParam(':user_id', $user_id);
                    if ($update_username_stmt->execute()) {
                        setcookie("username", $new_username, 0, '/');
                        die('Username update successful.');
                    }
                } catch (PDOException $e) {
                    die('MySql Error: ' . $e->getMessage());
                }
            }
            break;
        default:
            break;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="styles/profile_settings.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container">
        <label for="">Your Avatar:</label>
        <img src="assets/avatars/<?php 
        if (isset($_COOKIE["avatar"]))
        {
            if ($_COOKIE["avatar"] !== "no_avatar")
            {
                echo $_COOKIE["avatar"]; 
            }
            else {
                echo "no-avatar.png";
            }
        }?>" alt="" width="45px" style="border-radius: 50px; margin-bottom: 20px;">

        <label for="">Your Username:</label>
        <input type="text" name="" id="newusername_inp" value="<?php echo $_COOKIE["username"]; ?>">
        <input type="file" name="avatar" id="avatarInput" accept=".png, .jpg, .jpeg, .gif" style="display: none;">
        <button class="update_avatar" type="submit">Update avatar</button>
        <button class="update_informations" type="submit">Update username</button>
        <button class="turn_back" type="submit">Turn back</button>
    </div>

    <script>
        document.querySelector('.turn_back').addEventListener('click', () => {
            window.location.href = 'index.php';
        });

        const avatarInp = document.querySelector('#avatarInput');


        document.querySelector('.update_informations').addEventListener('click', function() {
            $.ajax({
                type: "POST",
                url: "profile_settings.php",
                data: {
                    type: "update_username",
                    username: document.querySelector('#newusername_inp').value
                },
                success: function(response) {
                    alert(response);
                    location.reload();
                },
                error: function(error) {

                }
            })
        });
        document.querySelector('.update_avatar').addEventListener('click', function() {

            avatarInp.click();
        });
        avatarInp.addEventListener('change', function() {
            var input = document.getElementById("avatarInput");
            var file = input.files[0];

            // Dosya türü kontrolü
            var allowedTypes = ["image/png", "image/jpeg", "image/jpg", "image/gif"];
            if (file && allowedTypes.includes(file.type)) {
                var formData = new FormData();
                formData.append("avatar", file);
                formData.append("type", 'update_avatar');

                // jQuery ile POST isteği gönder
                $.ajax({
                    url: "profile_settings.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response);
                    },
                    error: function(xhr, status, error) {
                        alert("Something went wrong: " + error);
                    }
                });
            } else {
                alert("Invalid file type. Only PNG, JPG, JPEG and GIF files are accepted.");
            }
        });
    </script>
</body>

</html>