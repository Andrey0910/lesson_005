<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 18:56
 */

namespace App;


class ControllerList extends MainController
{
    public function index(){
        $this->view->list();
    }
}