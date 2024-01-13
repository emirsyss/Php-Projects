<script type="text/javascript">
    const chatcontent = document.querySelector('.chat_content');

    let user_id;
    let user_avatar;
    let unseen_messages;


    var socket = new WebSocket("ws://localhost:8080");

    socket.addEventListener('open', function(event) {
        console.log("WebSocket connection successful.");
    });

    socket.addEventListener('message', function(event) {
        var receivedMessage = JSON.parse(event.data);

        var scrool_permission = false;

        var maths = chatcontent.scrollHeight - chatcontent.scrollTop;

        if (maths <= chatcontent.clientHeight + 1) {
            scrool_permission = true;
        }

        SendMessageFromServer(receivedMessage.message,
            receivedMessage.sender,
            receivedMessage.sender_id,
            receivedMessage.timestamp);
        if (receivedMessage.open) {
            chatcontent.scrollTop = chatcontent.scrollHeight;
        }

        if (scrool_permission == true) {
            chatcontent.scrollTop = chatcontent.scrollHeight;
        } else {
            unseen_messages += 1;
            document.querySelector('.unseen_messages').style.display = 'flex';
            document.querySelector('.unseen_messages_count').textContent = unseen_messages + " unseen messages";
        }


    })

    const msgsend_btn = document.querySelector('.msgsend_btn');

    msgsend_btn.addEventListener('click', () => {
        const my_msg = document.querySelector('.my_msg').value;

        if (my_msg.length > 0) {
            SendMessage(my_msg);
        }
    });
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            const my_msg = document.querySelector('.my_msg').value;

            if (my_msg.length > 0) {
                SendMessage(my_msg);
            }
        }
    });

    async function SendMessage(msg) {
        try {
            const avatar = document.createElement('img');
            var avatarSrc = await GetUserAvatar(user_id);

            if (avatarSrc === 'no_avatar') {
                avatar.src = 'assets/avatars/no-avatar.png';

            } else {
                avatar.src = 'assets/avatars/' + avatarSrc;
            }
            avatar.className = 'avatarimg';
            avatar.id = user_id;
            avatar.style.width = '45px';
            avatar.style.height = '45px';

            const username = document.createElement('p');
            username.innerHTML = '<?php echo $_COOKIE["username"]; ?>';

            var now = new Date();
            const date = document.createElement('p');
            date.style.color = '#858585';
            date.innerHTML = now.toLocaleDateString() + ' ' + now.toLocaleTimeString();
            date.style.fontSize = '0.7rem';

            const username_and_date = document.createElement('div');
            username_and_date.style.display = 'flex';
            username_and_date.style.alignItems = 'center';
            username_and_date.style.gap = '8px';
            username_and_date.appendChild(username);
            username_and_date.appendChild(date);


            const user_message = document.createElement('p');
            user_message.innerHTML = msg;

            const message_content = document.createElement('div');
            message_content.appendChild(username_and_date);
            message_content.appendChild(user_message);

            const message = document.createElement('p');
            message.style.display = 'flex';
            message.style.gap = '10px';
            message.className = 'msg';
            message.appendChild(avatar);
            message.appendChild(message_content);

            chatcontent.appendChild(message);

            var messageObject = {
                sender: username.textContent,
                sender_id: user_id,
                message: msg,
                timestamp: now.toLocaleDateString() + ' ' + now.toLocaleTimeString()
            };
            socket.send(JSON.stringify(messageObject));

            const my_msg = document.querySelector('.my_msg');
            my_msg.value = '';

            chatcontent.scrollTop = chatcontent.scrollHeight;

        } catch (error) {
            console.error(error);
        }
    }
    let windowload = 0;
    async function SendMessageFromServer(msg, sender, sender_id, timestamp) {
        try {
            var avatarSrc2 = "assets/avatars/no-avatar.png";
            const avatar2 = document.createElement('img');
            avatar2.src = avatarSrc2;
            avatar2.className = 'avatarimg';
            avatar2.id = sender_id;
            avatar2.style.width = '45px';
            avatar2.style.height = '45px';

            const username_and_date2 = document.createElement('div');
            username_and_date2.style.display = 'flex';
            username_and_date2.style.alignItems = 'center';
            username_and_date2.style.gap = '8px';

            const username2 = document.createElement('p');
            username2.innerHTML = await GetUserName(sender_id);

            const date2 = document.createElement('p');
            date2.style.color = '#858585';
            date2.innerHTML = timestamp;
            date2.style.fontSize = '0.7rem';

            username_and_date2.appendChild(username2);
            username_and_date2.appendChild(date2);

            const user_message2 = document.createElement('p');
            user_message2.innerHTML = msg;

            const message_content2 = document.createElement('div');
            message_content2.appendChild(username_and_date2);
            message_content2.appendChild(user_message2);

            const message2 = document.createElement('p');
            message2.style.display = 'flex';
            message2.style.gap = '10px';
            message2.className = 'msg';
            message2.appendChild(avatar2);
            message2.appendChild(message_content2);

            chatcontent.appendChild(message2);


        } catch (error) {
            console.error(error);
        }
    }

    window.onload = function() {
        GetUserId();
    }

    function GetUserId() {
        $.ajax({
            type: "POST",
            url: "get_info.php",
            data: {
                type: "GetUserId"
            },
            success: function(response) {
                user_id = response;
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function GetUserAvatar(userid) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "POST",
                url: "get_info.php",
                data: {
                    type: "GetUserAvatar",
                    id: userid
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }
    function GetUserName(userid) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "POST",
                url: "get_info.php",
                data: {
                    type: "GetUserName",
                    id: userid
                },
                success: function(response) {
                    resolve(response);
                },
                error: function(error) {
                    reject(error);
                }
            });
        });
    }

    document.querySelector('#profile-settings-btn').addEventListener('click', () => {
        window.location.href = 'profile_settings.php';
    });

    document.addEventListener('DOMContentLoaded', function() {

        chatcontent.addEventListener('scroll', function() {

            if (chatcontent.scrollHeight - chatcontent.scrollTop === chatcontent.clientHeight) {
                unseen_messages = 0;
                document.querySelector('.unseen_messages').style.display = 'none';
            }
            else if (chatcontent.scrollHeight - chatcontent.scrollTop <= chatcontent.clientHeight + 5) {
                unseen_messages = 0;
                document.querySelector('.unseen_messages').style.display = 'none';
            }

            var imgElements = chatcontent.querySelectorAll('img');

            imgElements.forEach(function(imgElement) {
                if (isElementInViewport(imgElement)) {
                    updateImageSrc(imgElement);
                }
            });


        });
    });

    function isElementInViewport(element) {
        var rect = element.getBoundingClientRect();

        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    async function updateImageSrc(imgElement) {
        imgElement.src = 'assets/avatars/' + await GetUserAvatar(imgElement.id);
    }

    document.querySelector('#see_messages').addEventListener('click', function() {
        chatcontent.scrollTop = chatcontent.scrollHeight;
        document.querySelector('.unseen_messages').style.display = 'none';
    });

</script>