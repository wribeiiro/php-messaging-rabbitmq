<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('Php queue', false, false, false, false);

$textMessage = $argv[1] ?? "Hello rabbit!";
$channel->basic_publish(
	new AMQPMessage($textMessage), 
	'', 
	'Php queue'
);

echo "Sender: " . $textMessage . PHP_EOL;

$channel->close();
$connection->close();
