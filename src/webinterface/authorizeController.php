<?php
namespace webinterface;

class authorizeController
{
    public static function login($username, $password){
        $url = main::getconfig()['cloudnet']['protocol'] . main::getconfig()['cloudnet']['ip'] . ":" . main::getconfig()['cloudnet']['port'] . main::getconfig()['cloudnet']['path'] . "/auth";
        $token = base64_encode($username.":".$password);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.$token
            ),
        ));

        $response = curl_exec($curl);
        if($response === FALSE){
            return array("success" => false, "response" => "server down");
        }

        curl_close($curl);
        $response = json_decode($response, true);

        if($response['success'] == true){
            $_SESSION['cn3-wi-access_token'] = $response['token'];

            return array("success" => true, "response" => "login success");
        } else {
            return array("success" => false, "response" => "password wrong");
        }
    }
}
