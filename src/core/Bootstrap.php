<?php

namespace App\Core;
use Exception;
class Bootstrap
{
    public function run()
    {
        $router = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = "authorization";
        $actionName = "index";
        //Получаем контроллер
        if (!empty($router[1])) {
            $controllerName = $router[1];
        }
        //Получаем действие
        if (!empty($router[2])) {
            $actionName = $router[2];
            $explode = explode('?', $actionName);
            $actionName = $explode[0];
        }
        $className = sprintf("\\App\\Controllers\\%sController", ucfirst(strtolower($controllerName)));
        if (!class_exists($className)){
            throw new NotFound("Класс ".$className." не найден.");
        }
        $controller = new $className;
        if (!method_exists($controller, $actionName)) {
            throw new NotFound("Метод ".$actionName." не найден в классе ". $className);
        }
        $controller->$actionName(strtolower($controllerName));
    }
}