<?php
class Bot extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $access_token = "EAAEtGB3rGGsBALF0lOKYQziyGK1Efnlf4End86PX6dng7vYZB0pveZCm4kISVsgVX78PDyulS5VOP9FfXpznbZBZCJRl2KyJZCYOfFFjow9x5vVqxrJE32QwngsolJxo6mWrsZAmChtT3X2OHi20PBpXZC4Lgyn3ZCMmjwbGaZBNGlV0AZB7a4H6Yq";
        
        $verify_token = "reiners-app";
        $hub_verify_token = null;

        if (isset($_REQUEST['hub_challenge'])) {
            $challenge = $_REQUEST['hub_challenge'];
            $hub_verify_token = $_REQUEST['hub_verify_token'];
        }

        if ($hub_verify_token === $verify_token) {
            echo $challenge;
        }
        $input = json_decode(file_get_contents('php://input'), true);
        log_message("debug",print_r($input));
        $sender = $input['entry'][0]['messaging'][0]['sender']['id'];
        $clientmessage = $input['entry'][0]['messaging'][0]['message']['text'];

        $url = 'https://graph.facebook.com/v2.9/me/messages?access_token=' . $access_token;

        if ($clientmessage == "hi") {
            $message_to_reply = 'hello';
        } else {
            $message_to_reply = 'Huh! what do you mean?';
        }
        $ch = curl_init($url);
        $jsonData = '{
            "recipient":{
                "id":"' . $sender . '"
            },
            "message":{
                "text":"' . $message_to_reply . '"
            }
        }';

        $jsonDataEncoded = $jsonData;
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        if (!empty($input['entry'][0]['messaging'][0]['message'])) {
            $result = curl_exec($ch);
        }
    }
}
