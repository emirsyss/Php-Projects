<?php

if (!isset($_COOKIE["email"])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Buddychat</title>
    <link rel="stylesheet" href="styles/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="profiles">
            <div class="profile-info">
                <?php
                $avatar = $_COOKIE["avatar"];
                $username = $_COOKIE["username"];

                echo '<img src="' . ($avatar == 'no_avatar' ? 'assets/avatars/no-avatar.png' : 'assets/avatars/' . $avatar) . '">';
                echo '<p>' . $username . '</p>';
                ?>
            </div>
            <div class="profile-btns">
                <i id="profile-settings-btn" class="fa-solid fa-gear"></i>
            </div>
        </div>
        <div class="chat">
            <div class="chat_content">

            </div>
            <div class="message_send">
                <div class="unseen_messages">
                    <div style="display: flex; gap: 5px; align-items: center;">
                        <i class="fa-solid fa-eye-slash"></i>
                        <p class="unseen_messages_count">unseen message</p>
                    </div>
                    <div style="align-items: center;">
                        <i id="see_messages" class="fa-solid fa-angle-down" style="cursor: pointer;"></i>
                    </div>
                </div>
                <div class="message_send_second_section">
                    <input class="my_msg" type="text" name="" id="" placeholder="Your Message">
                    <button class="msgsend_btn"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
                </div>
            </div>
        </div>
    </div>

    <?php
    include "chat_functions_js.php";
    ?>
</body>

</html>