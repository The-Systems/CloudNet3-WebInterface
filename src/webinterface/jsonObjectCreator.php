<?php

namespace webinterface;

class jsonObjectCreator
{

    public static function createServiceTaskObject(string $name, int $memory, string $env, ?string $node, int $defaultPort,
                                                   bool $static, bool $autoDeleteOnStop, bool $maintenance): string|false
    {
        $task = array(
            "name" => $name,
            "runtime" => "jvm",
            "javaCommand" => null,
            "disableIpRewrite" => false,
            "maintenance" => $maintenance,
            "autoDeleteOnStop" => $autoDeleteOnStop,
            "staticServices" => $static,
            "associatedNodes" => isset($node) ? array($node) : [],
            "groups" => [],
            "deletedFilesAfterStop" => [],
            "processConfiguration" => array(
                "environment" => strtoupper($env),
                "maxHeapMemorySize" => $memory,
                "jvmOptions" => [],
                "processParameters" => []
            ),
            "startPort" => $defaultPort,
            "minServiceCount" => 1,
            "includes" => [],
            "templates" => array(array(
                "prefix" => $name,
                "name" => "default",
                "storage" => "local",
                "alwaysCopyToStaticServices" => false
            )),
            "deployments" => [],
            "properties" => new \ArrayObject()
        );
        return json_encode($task);
    }
}