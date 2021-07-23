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
$route = $app->route;

// check if we already have a session
session_start();

if (!isset($_SESSION['cn3-wi-csrf'])) {
    $_SESSION['cn3-wi-csrf'] = uniqid();
}

if (isset($_SESSION['cn3-wi-access_token'])) {
    // check if token valid, and refresh
    $result = $main::buildDefaultRequest("session/refresh");
    if ($result['success'] === true) {
        $_SESSION['cn3-wi-access_token'] = $result['token'];
    } else {
        unset($_SESSION['cn3-wi-access_token']);
        header('Location: ' . main::getUrl());
        die();
    }

    $route->any('/', function () use ($main) {
        include "../pages/header.php";
        include "../pages/webinterface/index.php";
        include "../pages/footer.php";
    });

    $app->route->group('/tasks', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/webinterface/task/index.php";
            include "../pages/footer.php";
        });

        $this->any('/?', function ($task_name) use ($main) {
            $task = main::buildDefaultRequest("task/" . $task_name, "GET", array(), array());
            if (!$task['success']) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFound");
                die();
            }

            $services_r = main::buildDefaultRequest("service", "GET", array(), array());
            $services = array();
            foreach ($services_r['services'] as $service) {
                if ($service['configuration']['serviceId']['taskName'] == $task_name) {
                    array_push($services, $service);
                }
            }

            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=csrfFailed");
                    die();
                }

                // FUNCTIONS
            }

            include "../pages/header.php";
            include "../pages/webinterface/task/task.php";
            include "../pages/footer.php";
        });

        $this->any('/?/?/console', function ($task_name, $service_name) use ($main) {
            $task = main::buildDefaultRequest("service/" . $service_name, "GET");
            if (!$task['success']) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFound");
                die();
            }

            $ticket = main::buildDefaultRequest("wsTicket");
            if (!$ticket['success']) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFound");
                die();
            }

            $ticket = $ticket['id'];

            include "../pages/header.php";
            include "../pages/webinterface/task/console.php";
            include "../pages/footer.php";
        });
    });

    $route->any('/cluster', function () use ($main) {
        if (isset($_POST['action'])) {
            if (!main::validCSRF()) {
                header('Location: ' . main::getUrl() . "/cluster?action&success=false&message=csrfFailed");
                die();
            }

            if ($_POST['action'] == "stopNode" and isset($_POST['node_id'])) {
                main::buildDefaultRequest("cluster/" . $_POST['node_id'] . "/command", "POST", array(), json_encode(array("command" => "stop")));
                // $action = \webinterface\main::buildDefaultRequest("cluster/" . $_POST['node_id'] . "/command", "POST", array(), json_encode(array("command" => "stop")));
                header('Location: ' . main::getUrl() . "/cluster?action&success=true&message=nodeStop");
                die();
            }
        }

        include "../pages/header.php";
        include "../pages/webinterface/cluster.php";
        include "../pages/footer.php";
    });

    // logout page
    $route->any('/logout', function () use ($main) {
        $main::buildDefaultRequest("session/logout");
        unset($_SESSION['cn3-wi-access_token']);
        header('Location: ' . main::getUrl());
        die();
    });
} else {
    $route->any('/', function () use ($main) {
        if (isset($_POST['action'])) {
            if (!main::validCSRF()) {
                header('Location: ' . main::getUrl() . "/?action&success=false&message=csrfFailed");
                die();
            }

            if ($_POST['action'] == "login" and isset($_POST['username']) and isset($_POST['password'])) {
                $action = authorizeController::login($_POST['username'], $_POST['password']);
                if ($action == LOGIN_RESULT_SUCCESS) {
                    header('Location: ' . main::getUrl());
                } else {
                    header('Location: ' . main::getUrl() . "/?action&success=false&message=loginFailed");
                }
                die();
            }
        }

        include "../pages/small-header.php";
        include "../pages/webinterface/login.php";
        include "../pages/footer.php";
    });
}
$app->route->end();