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
$main = new main($config, $version,);

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
    $result = authorizeController::loginToken($_SESSION['cn3-wi-access_token']);
    if ($result != LOGIN_RESULT_SUCCESS) {
        unset($_SESSION['cn3-wi-access_token']);
        header('Location: ' . main::getUrl());
        die();
    }

    $route->any('/', function () use ($main) {
        include "../pages/header.php";
        include "../pages/action-modal.php";
        include "../pages/webinterface/dashboard.php";
        include "../pages/footer.php";
    });

    $app->route->group('/tasks', function () use ($main) {
        $this->any('/', function () use ($main) {
            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/cluster?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST['action'] == "createTask" and isset($_POST['name'])) {
                    // validate that all required values are there
                    $name = $_POST['name'];
                    $ram = $_POST['ram'];
                    $env = $_POST['environment'];
                    $node = $_POST['node'];
                    $startPort = $_POST['port'];
                    $static = $_POST['static'];
                    $autoDeleteOnStop = $_POST['auto_delete_on_stop'];
                    $maintenance = $_POST['maintenance'];

                    if (isset($name, $ram, $env, $node, $startPort)) {
                        $taskData = webinterface\jsonObjectCreator::createServiceTaskObject(
                            $name, $ram, $env,
                            $node === "all" ? array() : array($node),
                            $startPort, isset($static), isset($autoDeleteOnStop), isset($maintenance)
                        );
                        $response = $main::buildDefaultRequest("tasks", "POST", params: $taskData);

                        header('Location: ' . main::getUrl() . "/tasks?action&success=true&message=taskCreated");
                        die();
                    }
                }
            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/task/index.php";
            include "../pages/footer.php";
        });

        $this->any('/?', function ($task_name) use ($main) {
            $task = main::buildDefaultRequest("tasks/" . strtolower($task_name), "GET", array(), array());
            if (empty($task)) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFoundTask");
                die();
            }

            $services_r = main::buildDefaultRequest("services", "GET", array(), array());
            $services = array();
            foreach ($services_r as $service) {
                if (strtolower($service['configuration']['serviceId']['taskName']) == strtolower($task_name)) {
                    array_push($services, $service);
                }
            }

            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST['action'] == "stopService" and isset($_POST['service_id'])) {
                    $response = $main::buildDefaultRequest("services/" . $_POST['service_id'] . "/stop", "GET");
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=true&message=stopService");
                    die();
                }

                if ($_POST['action'] == "createService" and isset($_POST['count'])) {
                    $main::buildDefaultRequest("services/" . strtolower($task_name) . "/" . $_POST['count'] . "/" . (isset($_POST['start']) ? "true" : "false"), "GET");
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=true&message=createService");
                    die();
                }

                if ($_POST['action'] == "startService" and isset($_POST['service_id'])) {
                    $main::buildDefaultRequest("services/" . $_POST['service_id'] . '/start', "GET");

                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=true&message=startService");
                    die();
                }
            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/task/task.php";
            include "../pages/footer.php";
        });

        $this->any('/?/delete', function ($task_name) use ($main) {
            $task = main::buildDefaultRequest("tasks/" . strtolower($task_name), "DELETE", array(), array());
            header('Location: ' . main::getUrl() . "/tasks?action&success=true&message=taskDelete");
            die();
        });

        $this->any('/?/edit', function ($task_name) use ($main) {
            $task = main::buildDefaultRequest("tasks/" . strtolower($task_name), "GET", array(), array());
            if (empty($task)) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFound");
                die();
            }

            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=false&message=csrfFailed");
                    die();
                }
                // FUNCTIONS
                if ($_POST['action'] == "editTask") {
                    $name = $_POST['name'];
                    $ram = $_POST['memory'];
                    $env = $_POST['environment'];
                    if (isset($_POST['node'])) {
                        $node = $_POST['node'];
                    } else {
                        $node = array();
                    }
                    if (isset($_POST['group'])) {
                        $group = $_POST['group'];
                    } else {
                        $group = array();
                    }

                    $startPort = $_POST['port'];
                    $static = $_POST['static'];
                    $autoDeleteOnStop = $_POST['auto_delete_on_stop'];
                    $maintenance = $_POST['maintenance'];

                    if (isset($name, $ram, $env, $node, $startPort)) {
                        $taskData = webinterface\jsonObjectCreator::createServiceTaskObject(
                            $name, $ram, $env, $node,
                            $startPort, isset($static), isset($autoDeleteOnStop), isset($maintenance), $group
                        );
                        $main::buildDefaultRequest("tasks", "POST", $taskData);
                        header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "/edit?action&success=true");
                        die();
                    } else {
                        header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "/edit?action&success=false&message=errorTask");
                    }
                }
            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/task/edit.php";
            include "../pages/footer.php";
        });

        $this->any('/?/?/console', function ($task_name, $service_name) use ($main) {
            $service = main::buildDefaultRequest("services/" . strtolower($service_name), "GET");
            if (empty($service)) {
                header('Location: ' . main::getUrl() . "/tasks?action&success=false&message=notFound");
                die();
            }

            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST['action'] == "sendCommand" and isset($_POST['command'])) {
                    $response = $main::buildDefaultRequest("services/" . $_POST['service_id'] . "/stop", "GET");
                    header('Location: ' . main::getUrl() . "/tasks/" . $task_name . "?action&success=true&message=stopService");
                    die();
                }
            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/task/console.php";
            include "../pages/footer.php";
        });
    });

    $route->group('/groups', function () use ($main) {
        $this->any('/', function () use ($main) {

            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/cluster?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST["action"] == "createGroup") {
                    $response = $main::buildDefaultRequest("groups", "POST");
                }
            }
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/groups/index.php";
            include "../pages/footer.php";
        });
    });

    $route->group('/cluster', function () use ($main) {
        $this->any('/', function () use ($main) {
            if (isset($_POST['action'])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/cluster?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST['action'] == "stopNode" and isset($_POST['node_id'])) {
                    main::buildDefaultRequest("cluster/" . $_POST['node_id'] . "/command", "POST", array(), json_encode(array("command" => "stop")));
                    $action = main::buildDefaultRequest("cluster/" . $_POST['node_id'] . "/command", "POST", array(), json_encode(array("command" => "stop")));
                    // two times, because cloudnet require two stop commands

                    header('Location: ' . main::getUrl() . "/cluster?action&success=true&message=nodeStop");
                    die();
                }

                if ($_POST['action'] == "deleteNode" and isset($_POST['node_id'])) {
                    main::buildDefaultRequest("cluster/" . $_POST['node_id'], "DELETE", array(), array());
                    header('Location: ' . main::getUrl() . "/cluster?action&success=true&message=nodeDelete");
                    die();
                }

                if ($_POST['action'] == "createNode" and isset($_POST['name'])) {
                    $action = main::buildDefaultRequest("cluster", "POST", array(), json_encode(array("properties" => array(), "uniqueId" => $_POST['name'], "listeners" => array((array("host" => $_POST['host'], "port" => $_POST['port']))))));
                    header('Location: ' . main::getUrl() . "/cluster?action&success=true&message=nodeCreate");
                    die();
                }

            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/cluster/index.php";
            include "../pages/footer.php";
        });

        $this->any('/?/console', function ($node_id) use ($main) {
            $cluster = main::buildDefaultRequest("node/" . $node_id, "GET");
            if (!$cluster['success']) {
                header('Location: ' . main::getUrl() . "/cluster?action&success=false&message=notFound");
                die();
            }

            $ticket = main::requestWsTicket("cluster?action&success=false&message=notFound");

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/cluster/console.php";
            include "../pages/footer.php";
        });
    });

    $app->route->group('/modules', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/modules/index.php";
            include "../pages/footer.php";
        });
    });

    $app->route->group('/players', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/players/index.php";
            include "../pages/footer.php";
        });
    });

    $app->route->group('/players', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/players/index.php";
            include "../pages/footer.php";
        });

        $this->any('/?', function ($uuid) use ($main) {
            if (isset($_POST["action"])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/players/" . $uuid . "?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST["action"] == "addGroup") {
                    main::buildDefaultRequest("players/" . $uuid . "/add", 'PUT', json_encode(array("group" => $_POST["permissionGroup"], "time" => $_POST["time"], "time_number" => $_POST["time_number"])));
                    header('Location: ' . main::getUrl() . "/players/" . $uuid . "?action&success=true&message=addGroupToPlayer");
                    die();
                }

                if ($_POST["action"] == "deleteGroup") {
                    main::buildDefaultRequest("players/" . $uuid . "/remove", 'PUT', json_encode(array("group" => $_POST["groupName"])));
                    header('Location: ' . main::getUrl() . "/players/" . $uuid . "?action&success=true&message=deleteGroupFromPlayer");
                    die();
                }

                if ($_POST["action"] == "addPermission") {
                    main::buildDefaultRequest("players/" . $uuid . "/add", 'PUT', $_POST["serviceGroup"] == "all" ?
                        json_encode(array("permission" => $_POST["permission"], "serviceGroup" => $_POST["serviceGroup"])) :
                        json_encode(array("permission" => $_POST["permission"])));
                    header('Location: ' . main::getUrl() . "/players/" . $uuid . "?action&success=true&message=addPermissionFromPlayer");
                    die();
                }

                if ($_POST["action"] == "deletePermission") {
                    main::buildDefaultRequest("players/" . $uuid . "/remove", 'PUT', json_encode(array("permission" => $_POST["permission"])));
                    header('Location: ' . main::getUrl() . "/players/" . $uuid . "?action&success=true&message=deletePermissionFromPlayer");
                    die();
                }
            }

            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/players/show.php";
            include "../pages/footer.php";
        });
    });

    $app->route->group('/permissions', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/permissions/index.php";
            include "../pages/footer.php";
        });

        $this->any('/?', function ($group_name) use ($main) {
            if (isset($_POST["action"])) {
                if (!main::validCSRF()) {
                    header('Location: ' . main::getUrl() . "/permissions/" . $group_name . "?action&success=false&message=csrfFailed");
                    die();
                }

                if ($_POST["action"] == "groupSettings") {
                    main::buildDefaultRequest("permissions", "PUT", json_encode(array("name" => $_POST["groupName"], "defaultGroup" => isset($_POST["defaultGroup"]), "edit_name" => $_POST["name"], "prefix" => $_POST["prefix"], "display" => $_POST["display"], "color" => $_POST["color"], "suffix" => $_POST["suffix"], "sortId" => $_POST["sortId"])));
                    header('Location: ' . main::getUrl() . "/permissions/" . $group_name . "?action&success=true&message=updatePermissionGroup");
                    die();
                }

                if ($_POST["action"] == "deletePermission") {
                    main::buildDefaultRequest("permissions/permission/delete", "POST", json_encode(array("permission" => $_POST["permissionName"], "groupName" => $group_name)));
                    header('Location: ' . main::getUrl() . "/permissions/" . $group_name . "?action&success=true&message=deletePermission");
                    die();
                }

                if ($_POST["action"] == "deleteGroup") {
                    main::buildDefaultRequest("permissions/group/delete", "POST", json_encode(array("name" => $_POST["groupName"], "groupName" => $group_name)));
                    header('Location: ' . main::getUrl() . "/permissions/" . $group_name . "?action&success=true&message=deleteGroupFromGroup");
                    die();
                }

                if ($_POST["action"] == "addPermission") {
                    main::buildDefaultRequest("permissions/permission/add", "POST", json_encode(array("permission" => $_POST["name"], "groupName" => $group_name)));
                    header('Location: ' . main::getUrl() . "/permissions/" . $group_name . "?action&success=true&message=addPermission");
                    die();
                }

            }
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/permissions/show.php";
            include "../pages/footer.php";
        });
    });

    $app->route->group('/profile', function () use ($main) {
        $this->any('/', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/profile/index.php";
            include "../pages/footer.php";
        });

        $this->any('/help', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/profile/help.php";
            include "../pages/footer.php";
        });

        $this->any('/settings', function () use ($main) {
            include "../pages/header.php";
            include "../pages/action-modal.php";
            include "../pages/webinterface/profile/settings.php";
            include "../pages/footer.php";
        });
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
        include "../pages/action-modal.php";
        include "../pages/webinterface/login.php";
        include "../pages/footer.php";
    });
}

$route->any('/*', function () use ($main) {
    header('Location: ' . main::getUrl());
    die();
});

$app->route->end();