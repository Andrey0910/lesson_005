<?php
require_once "../core/MainController.php";
require_once "../core/MainView.php";
require_once "../models/ModelUsers.php";
require ("../vendor/autoload.php");
$router = explode('/', $_SERVER['REQUEST_URI']);
$controllerName = "authorization";
$actionName = "index";
//Получаем контроллер
if (!empty($router[1])){
    $controllerName = $router[1];
}
//Получаем действие
if (!empty($router[2])){
    $actionName = $router[2];
    $explode = explode('?', $actionName);
    $actionName = $explode[0];
}
$fileName = "../controllers/Controller".ucfirst(strtolower($controllerName)).".php";
try{
    if (file_exists($fileName)){
        require_once $fileName;
    }
    else{
        throw new Exception ("File not found");
    }
    $className = '\App\\Controller'.$controllerName;
    if (class_exists($className)){
        $controller = new $className;
    }
    else{
        throw new Exception("Class not found");
    }
    if (method_exists($controller, $actionName)){
        $controller->$actionName(strtolower($controllerName));
    }
    else{
        throw new Exception("Method not found");
    }
}
catch (Exception $e){
    require "../errors/404.php";
}