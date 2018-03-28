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
        $file = $_FILES['photo'];
        //var_dump(__DIR__ . "/". $_FILES["name"] );
        //die();
        $this->getImage($file);
        //var_dump($_FILES);
        //die();
        //echo "-----".$photo;
        //$this->moveFile();
        //$typePhoto = end(explode('.', $photo));
        session_start();
        $_SESSION["typePhoto"] = "yes";
//        if (!$this->getImage($photo)) {
//            $_SESSION["typePhoto"] = "no";
//            header("Location: /reg");
//        }
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
        echo "<br>", "pathFile == ".$pathFile;
        echo "<br>", "nameFile == ".$nameFile;
        move_uploaded_file("D:\OSPanel\userdata\temp\php39DA.tmp", "zhivotnye_tigr_21710.jpg");
        die();
        if (preg_match('/jpg/', $file['name']) //jpg
            or preg_match('/png/', $file['name'])
            or preg_match('/gif/', $file['name'])
        ) {
            $pathFile = $file['tmp_name'];
            $nameFile = $file['name'];
            die();
            echo $file['name'];
            echo "<br>", $file['type'];
            if (!$this->getImage($file['tmp_name'])//preg_match('/jpg/', $file['type']) //jpg
                or preg_match('/png/', $file['type'])
                or preg_match('/gif/', $file['type'])
            ) {
                move_uploaded_file($file['tmp_name'], $file['name']);
            }
        } else {
            die("Ошибка загрузки файла.");
            echo "<a href='/reg'>Назад</a>";
        }
    }

    public function getImage($file)
    {
        $pathTempFile = $file['tmp_name'];
        $nameFile = $file['name'];
        $data = file_get_contents($pathTempFile);
        $img = imagecreatefromstring($data);
        if (!$img){
            die("Ошибка загрузки файла.");
            echo "<a href='/reg'>Назад</a>";
        }
        $dir = "photo";
        //$file = (string)time().".txt";
        if (!file_exists($dir)) {
            mkdir($dir, 0700, true);
        }
        $path = "./".$dir."/".$nameFile;
        //file_put_contents($path, $img);
        file_put_contents(imagejpeg($img));
        //file_put_contents($path, imagejpeg($img));
        imagedestroy($img);
        //return $img;
    }
}