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
    public function index($nameView)
    {
        $this->view->render($nameView);
    }
    public function authorization(){
        $login = $_POST['login'];
        $password = $_POST['password'];
        $modelUsers = new ModelUsers();
        $data = $modelUsers->userExist($login, $password);
        if (count($data) > 0){
            $name = $data[0]->name;
            session_start();
            $_SESSION["user"] = $name;
            header("Location: /list");
        }
        else{
            header("Location: /reg");
        }
    }
    public function logout(){
        session_start();
        $_SESSION["user"] = null;
        header("Location: /authorization");
    }
}