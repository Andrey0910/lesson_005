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
    public function index($nameView)
    {
        $this->view->render($nameView);
    }

    public function reg()
    {
        $password_hash = null;
        $login = $_POST['login'];
        $password = $_POST['password'];
        $passwordRepeat = $_POST['passwordRepeat'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $description = $this->clearAll($_POST['description']);
        $photo = $_POST['photo'];
        session_start();
        if (empty($password) && empty($passwordRepeat)) {
            header("Location: /reg");
        }
        $_SESSION["passwordRepeat"] = "yes";
        if (!empty($login) && $password == $passwordRepeat) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $data = [
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
        } else {
            $_SESSION["passwordRepeat"] = "no";
            header("Location: /reg");
        }
        $this->moveFile();
    }

    //Очишаем вводимую информацию от вреданосного кода.
    public function clearAll($data)
    {
        $data = strip_tags($data);
        $data = htmlspecialchars($data, ENT_QUOTES);
        $data = htmlentities($data);
        return $data;
    }

    public function moveFile()
    {
        $file = $_FILES['photo'];
        $pathFile = $file['tmp_name'];
        $nameFile = $file['name'];
        if (preg_match('/jpg/', $file['name']) //jpg
            or preg_match('/png/', $file['name'])
            or preg_match('/gif/', $file['name'])
        ) {
            $data = file_get_contents($pathFile);
            $img = imagecreatefromstring($data);
            if (!$img){
                echo "Ошибка загрузки файла.", "<a href='/reg'>Назад</a>";
                die();
            }
            $dir = "../photo";
            if (!file_exists($dir)) {
                mkdir($dir, 0700, true);
            }
            move_uploaded_file($pathFile, $dir ."/".$nameFile);
        } else {
            echo "Ошибка загрузки файла.", "<a href='/reg'>Назад</a>";
            die();
        }
    }
}