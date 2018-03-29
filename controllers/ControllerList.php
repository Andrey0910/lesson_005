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
    public function index($nameView){
        $modelUsers = new ModelUsers();
        $data = $modelUsers->getAll();
        $this->view->render($nameView, $data);
    }
}