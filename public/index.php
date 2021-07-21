<?php
use webinterface;
session_start();

define('DS', DIRECTORY_SEPARATOR, true);
define('BASE_PATH', __DIR__ . DS, TRUE);


$path_vendor = __DIR__ . '/../vendor/autoload.php';
$path_config = BASE_PATH . '../config/config.php';
$path_version = BASE_PATH . '../config/version.php';
$path_message = BASE_PATH . '../config/message.json';

if (file_exists($path_vendor)) {
    require $path_vendor;
} else {
    echo '<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/vendor/autoload.php" konnte nicht gefunden werden.</h3><h3>Führe im Webseiten-Root "composer install" aus!</h3>';
    die();
}

if (file_exists($path_config)) {
    require $path_config;
} else {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/config.php" konnte nicht gefunden werden.</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

if (file_exists($path_version)) {
    require $path_version;
} else {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/version.php" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

if (!file_exists($path_message)) {
    die('<h1><span style="color: #FF0000">Ein Fehler ist aufgetreten.</span></h1><h3>Die Datei "/config/message.json" konnte nicht gefunden werden</h3><h3>Führe das Setup mit "wisetup" im Master erneut aus!</h3>');
}

$main = new webinterface($config, $version);

$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);

$route = $app->route;


$this->any('/', function () {

});

$route->end();