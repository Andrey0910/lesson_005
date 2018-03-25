<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 19:04
 */

namespace App;


class ControllerFilelist extends MainController
{
    public function index($nameView){
        $this->view->render($nameView);
    }
}