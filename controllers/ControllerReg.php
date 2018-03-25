<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 17:47
 */

namespace App;


class ControllerReg extends MainController
{
    public function index($nameView){
        $this->view->render($nameView);
    }
}