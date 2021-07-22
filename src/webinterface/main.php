<?php
namespace webinterface;

use JetBrains\PhpStorm\Pure;

class main
{
    protected static array $configObj;
    protected static array $versionObj;

    public function __construct($config, $version)
    {
        self::$configObj = $config;
        self::$versionObj = $version;
    }

    public static function getConfig(): array
    {
        return self::$configObj;
    }
    public static function getVersionObj(): array
    {
        return self::$versionObj;
    }


    public static function buildRequest($url, $token, $method = "POST", $params = array()){
        $url = self::getconfig()['cloudnet']['protocol'] . self::getconfig()['cloudnet']['ip'] . ":" . self::getconfig()['cloudnet']['port'] . self::getconfig()['cloudnet']['path'] . "/".$url;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer '.$token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response, true);
    }

    public static function getUrl($only = "all"): string
    {
        $config = self::$configObj;

        $main = $config['url']['main'];
        $ssl = $config['url']['ssl'];
        $pfad = $config['url']['pfad'];
        $without_sub = $config['url']['without_sub'];

        if ($only == "all") {
            return $ssl . "" . $main . "" . $pfad;
        } elseif ($only == "pfad") {
            return $pfad;
        } elseif ($only == "main") {
            return $main;
        } elseif ($only == "ssl") {
            return $ssl;
        } elseif ($only == "without_sub") {
            return $without_sub;
        } else {
            return $ssl . "" . $main . "" . $pfad;
        }
    }
    public static function getMessage($key){
        $file = dirname(__FILE__) . "/../../config/message.json";
        $json = file_get_contents($file);
        $message = json_decode($json, true);
        if(isset($message[$key])) {
            return $message[$key];
        } else {
            return $key;
        }
    }

    #[Pure] public static function getCurrentVersion()
    {
        return main::getVersionObj()['version'];
    }
    public static function getVersion(): array
    {
        $url = main::getVersionObj()['version_url'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $json = curl_exec($ch);
        curl_close($ch);

        $response = curl_exec($ch);
        if($response === FALSE){
            return array("success" => false, "response" => "server down");
        }
        return json_decode($json, true);
    }

}