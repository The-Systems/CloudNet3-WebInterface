<?php

namespace webinterface;

define('BASE_PATH', __DIR__ . DIRECTORY_SEPARATOR);

class fileController
{
    protected static string $path_config = BASE_PATH . '../../config/config.php';
    protected static string $path_version = BASE_PATH . '../../config/version.php';
    protected static string $path_message = BASE_PATH . '../../config/messages.json';

    public static function dieWhenFileMissing()
    {
        if (!file_exists(self::$path_config)) {
            die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/config.php" konnte nicht gefunden werden.</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
        }

        if (!file_exists(self::$path_version)) {
            die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/version.php" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
        }

        if (!file_exists(self::$path_message)) {
            die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/message.json" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
        }
    }

    public static function getConfigurationPath(): string
    {
        return self::$path_config;
    }

    public static function getVersionFilePath(): string
    {
        return self::$path_version;
    }
}