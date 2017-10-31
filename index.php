<?php 

use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

$channel_token = 'Ig2JrQiX3KtsjWjuANrIT0cR8kphEYV/HQWHh9IRxQ2WQgKIryqzhdpmHe+UhZFksyVb1ub1VVMxzU2xrHpZKAcYULaf64MJHcaD/7XrFySsfWNwaq5AX/G8CtIw+IC/00QQF98+D1gPoe7WOzL2vgdB04t89/1O/w1cDnyilFU=';
$channel_secret = 'f814df6025f5ffc1e8999f6a8c6f99e9';

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

    // Loop through each event
    foreach ($events['events'] as $event) {

        // Line API send a lot of event type, we interested in message only.
        if ($event['type'] == 'message') {

            // Get replyToken
            $replyToken = $event['replyToken'];

            switch($event['message']['type']) {

                case 'image':
                    $messageID = $event['message']['id'];
                    $respMessage = 'Hello, your image ID is '. $messageID;

                    break;
                default:
                    $respMessage = 'Please send image only';
                    break;
            }

            $httpClient = new CurlHTTPClient($channel_token);
            $bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));

            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
        }
    }
}

echo "OK";
