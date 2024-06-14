<?php
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require_once 'vendor/autoload.php';

$client = new Client(['base_uri' => 'http://localhost/Listify/']);

function postReqCheckEmailAvailability($client,$email){
    try {
        $response = $client->post('email-availability', [
            'json' => ['Email' => $email]
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return json_encode([$data['status'],$data['message']]);
    } catch (RequestException $e) {

        if ($e->hasResponse()) {
            $statusCode = $e->getResponse()->getStatusCode();
            $message = $e->getResponse()->getReasonPhrase();
            return json_encode([$statusCode,$message]);
        } else {
            $status = 'error';
            return json_encode([$status,$e->getMessage()]);
        }
    }
}