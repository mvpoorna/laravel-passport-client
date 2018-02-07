<?php

require "vendor/autoload.php";

$client = new GuzzleHttp\Client;

//try {
    $response = $client->post('http://localhost/LaravelExampleApplication/public/oauth/token', [
        'form_params' => [
            'client_id' => 2,
            // The secret generated when you ran: php artisan passport:install
            'client_secret' => 'mN9Q6WEQFrYcmSm8UliOGKyXzvy8q75hJS5frKnE',
            'grant_type' => 'password',
            'username' => 'mv.poorna@gmail.com',
            'password' => '123456',
            'scope' => '*',
        ]
    ]);

    // You'd typically save this payload in the session
    $auth = json_decode( (string) $response->getBody() );

    $response = $client->get('http://localhost/LaravelExampleApplication/public/api/todos', [
        'headers' => [
            'Authorization' => 'Bearer '.$auth->access_token,
        ]
    ]);

    $todos = json_decode( (string) $response->getBody() );

    $todoList = "";
    foreach ($todos as $todo) {
        $todoList .= "<li>{$todo->task}".($todo->done ? '✅' : '')."</li>";
    }

    echo "<ul>{$todoList}</ul>";

//} catch (GuzzleHttp\Exception\BadResponseException $e) {
//    echo "Unable to retrieve access token.";
//}