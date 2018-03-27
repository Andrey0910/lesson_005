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
        $data = $modelUsers->getUserLogin($login);
        $user = null;
        foreach ($data as $item){
            $passwordHash = $item->password;
            if (password_verify($password, $passwordHash)){
                $user = $item;
                break;
            }
        }
        if (!empty($user)){
            session_start();
            $_SESSION["user"] = $user->login;
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