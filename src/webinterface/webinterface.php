<?php

class webinterface
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
    public static function getVersion(): array
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
}