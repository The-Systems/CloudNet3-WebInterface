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

    public static function getUrl($only = "all"): string
    {
        $config = self::$configObj;

        $main = $config['url']['main'];
        $ssl = $config['url']['ssl'];
        $pfad = $config['url']['pfad'];
        $without_sub = $config['url']['without_sub'];

        if ($only == "pfad") {
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

    #[Pure] public static function provideUrl($subPath): string
    {
        return self::getconfig()['cloudnet']['protocol'] . self::getconfig()['cloudnet']['ip'] . ":" . self::getconfig()['cloudnet']['port'] . self::getconfig()['cloudnet']['path'] . "/$subPath";
    }

    #[Pure] public static function provideSocketUrl(): string
    {
        return self::getconfig()['cloudnet']['socket']['protocol'] . self::getconfig()['cloudnet']['socket']['ip'] . ":" . self::getconfig()['cloudnet']['socket']['port'] . self::getconfig()['cloudnet']['socket']['path'];
    }

    public static function requestWsTicket(string $errorPathRedirect): string
    {
        $ticket = self::buildDefaultRequest("wsTicket");
        if (!$ticket['success']) {
            header('Location: ' . main::getUrl() . "/$errorPathRedirect");
            die();
        }

        return $ticket['id'];
    }

    public static function buildDefaultRequest($url, $method = "GET", $params = array(), $debug = false): mixed
    {
        return self::buildRequest($url, $_SESSION['cn3-wi-access_token'], $method, $params, $debug);
    }

    public static function buildRequest($url, $token, $method = "POST", $params = array(), $debug = false): mixed
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => self::provideUrl($url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $params,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Authorization: Basic ' . $token,
                'Cookie: ' . $_SESSION["cn3-wi-cookie"]
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response === FALSE) {
            return array("success" => "false");
        }

        if ($debug == true) {
            return $response;
        } else {
            return json_decode($response, true);
        }
    }

    public static function getMessage($key)
    {
        $file = dirname(__FILE__) . "/../../config/message.json";
        $json = file_get_contents($file);
        $message = json_decode($json, true);
        if (isset($message[$key])) {
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
        if ($response === FALSE) {
            return array("success" => false, "response" => "server down");
        }

        return json_decode($json, true);
    }

    public static function testIfLatestVersion(): array
    {
        $version = self::getCurrentVersion();
        $version_latest = self::getVersion();

        if (!$version_latest['success']) {
            return array("success" => false, "response" => array(
                "error_code" => 503,
                "error_message" => "version-server down"
            ));
        }

        if ($version != $version_latest['response']['version']) {
            return array("success" => false, "response" => array(
                "error_code" => 202,
                "error_message" => "not latest version",
                "error_extra" => array(
                    "current" => $version,
                    "latest" => $version_latest['response']['version'])
            ));
        } else {
            return array("success" => true);
        }
    }

    public static function validCSRF(): bool
    {
        return isset($_POST['csrf']) ?? false and $_POST['csrf'] == $_SESSION['cn3-wi-csrf'];
    }
}