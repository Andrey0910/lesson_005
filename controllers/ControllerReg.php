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
    public function reg(){
        $password_hash = null;
        $login = $_POST['login'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $description = $_POST['description'];
        $photo = $_POST['photo'];
        $typePhoto = end(explode('.', $photo));
        session_start();
        $_SESSION["typePhoto"] = "yes";
        if ($typePhoto !== "jpg"){
            $_SESSION["typePhoto"] = "no";
            header("Location: /reg");
        }
        if (empty($password) && empty($passwordRepeat)){
            header("Location: /reg");
        }
        $_SESSION["passwordRepeat"] = "yes";
        if (!empty($login) && $password == $passwordRepeat){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $data= [
                'login' => $login,
                'password' => $password_hash,
                'name' => $name,
                'age' => $age,
                'description' => $description,
                'photo' => $photo
            ];
            $modelUsers = new ModelUsers();
            $modelUsers->userReg($data);
            $_SESSION["user"] = $login;
            header("Location: /list");
        }
        else{
            $_SESSION["passwordRepeat"] = "no";
            header("Location: /reg");
        }
    }
}