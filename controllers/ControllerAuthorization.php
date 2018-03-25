<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 18:31
 */

namespace App;


class ControllerAuthorization extends MainController
{
    public function index()
    {
        $this->view->authorization();
    }
}