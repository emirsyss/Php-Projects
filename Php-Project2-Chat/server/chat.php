<?php

namespace MyApp;

use PDO;

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require_once "../connection.php";


class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $con;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;


        global $con;
        $this->con = $con;

        echo "Server started.";
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo "New Connection ({$conn->resourceId})\n";

        $select_allmessages_sql = "SELECT sender, sender_id, message, timestamp FROM chat_messages";
        $select_allmessages_stmt = $this->con->prepare($select_allmessages_sql);
        $select_allmessages_stmt->execute();

        $allmessages = $select_allmessages_stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($allmessages as $message) {
            $sender = $message['sender'];
            $sender_id = $message['sender_id'];
            $message_content = $message['message'];
            $timestamp = $message['timestamp'];

            $conn->send(json_encode([
                'open' => 'true',
                'sender' => $sender,
                'sender_id' => $sender_id,
                'message' => $message_content,
                'timestamp' => $timestamp
            ]));
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message_data = json_decode($msg, true);

        $sender = $message_data["sender"];
        $sender_id = $message_data["sender_id"];
        $message = $message_data["message"];
        $timestamp = $message_data["timestamp"];

        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }

        echo "New Message: " . $msg . "\n";

        $message_add_sql = "INSERT INTO chat_messages (sender, sender_id, message, timestamp) VALUES (:sender, :sender_id, :message, :timestamp)";
        $message_add_stmt = $this->con->prepare($message_add_sql);
        $message_add_stmt->bindParam(':sender', $sender);
        $message_add_stmt->bindParam(':sender_id', $sender_id);
        $message_add_stmt->bindParam(':message', $message);
        $message_add_stmt->bindParam(':timestamp', $timestamp);
        $message_add_stmt->execute();
    }


    public function onClose(ConnectionInterface $conn)
    {
        echo "Client {$conn->resourceId} left.\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Something went wrong: {$e->getMessage()}\n";

        $conn->close();
    }
}
