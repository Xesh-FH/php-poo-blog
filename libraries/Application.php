<?php

class Application
{
    const CONTROLLER_STRING = "Controller";

    public static function process()
    {
        $controllerName = "Article" . self::CONTROLLER_STRING;
        $task = "index";

        if (!empty($_GET['controller'])) {
            $controllerName = ucfirst($_GET['controller']) . self::CONTROLLER_STRING;
        }

        if (!empty($_GET['task'])) {
            $task = $_GET['task'];
        }

        $controllerName = "\Controllers\\" . $controllerName;
        $controller = new $controllerName();
        $controller->$task();
    }
}
