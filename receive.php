<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('Php queue', false, false, false, false);

echo "[*] Waiting for messages. To exit press CTRL+C" . PHP_EOL;

$callback = function ($msg) {
    echo 'Received: ' . $msg->body . PHP_EOL;
};

$channel->basic_consume('Php queue', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
