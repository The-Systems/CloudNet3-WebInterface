<?php

use webinterface\main;
use webinterface\fileController;
use webinterface\authorizeController;

// require some files
require __DIR__ . '/../vendor/autoload.php';
// ensure all necessary files are there
fileController::dieWhenFileMissing();

// files
require fileController::getVersionFilePath();
require fileController::getConfigurationPath();

// create instance of main controller
$main = new main($config, $version);

// create app route controller
$app = System\App::instance();
$app->request = System\Request::instance();
$app->route = System\Route::instance($app->request);

// check if we already have a session
session_start();

$app->route->any('/', function () use ($main) {
    if (isset($_GET['action']) and $_GET['action'] == "logout") {
        session_unset();
        header('Location: ' . strtok($_SERVER["REQUEST_URI"], '?'));
        die();
    } else if (isset($_SESSION['cn3-wi-access_token'])) {
        // try to refresh the session token
        $result = $main::buildDefaultRequest("session/refresh");
        if ($result['success'] === true) {
            // success, use the updated token and redirect to the dashboard
            $_SESSION['cn3-wi-access_token'] = $result['token'];
            redirectToDashboard();
            return;
        } else {
            // invalid token in session cache, just clear and run login
            session_unset();
        }
    } else if (isset($_POST['action']) and $_POST['action'] == "login" and isset($_POST['username']) and isset($_POST['password'])) {
        $loginResult = authorizeController::login($_POST['username'], $_POST['password']);
        if ($loginResult == LOGIN_RESULT_SUCCESS) {
            redirectToDashboard();
            return;
        }
    }

    displayLoginPage();
});
$app->route->end();

function displayLoginPage()
{
    include "../pages/small-header.php";
    include "../pages/webinterface/login.php";
    include "../pages/footer.php";
}

function redirectToDashboard()
{
    include "../pages/header.php";
    include "../pages/webinterface/index.php";
    include "../pages/footer.php";
}