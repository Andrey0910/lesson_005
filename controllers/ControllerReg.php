<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 17:47
 */

namespace App;

use \Intervention\Image\ImageManager;
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
        $photo =  (string)random_int(0, 10000).$_FILES['photo']['name'];
        session_start();
        if (empty($password) && empty($passwordRepeat)) {
            header("Location: /reg");
        }
        $_SESSION["passwordRepeat"] = "yes";
        if (!empty($login) && $password == $passwordRepeat) {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $this->moveFile($photo);
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

    public function moveFile($nameFile)
    {
        $file = $_FILES['photo'];
        $pathFile = $file['tmp_name'];
        //$nameFile = $_POST['login'].$file['name'];
        if (preg_match('/jpg/', $file['name']) //jpg
            or preg_match('/png/', $file['name'])
            or preg_match('/gif/', $file['name'])
        ) {
            if (!file_exists($pathFile)){
                echo "Ошибка загрузки файла.", "<a href='/reg'>Назад</a>";
                die();
            }
            $data = file_get_contents($pathFile);
            $img = imagecreatefromstring($data);
            if (!$img){
                echo "Ошибка загрузки файла.", "<a href='/reg'>Назад</a>";
                die();
            }
            $dir = "../www/photo";
            if (!file_exists($dir)) {
                mkdir($dir, 0700, true);
            }
            $pathLocal = $dir ."/".$nameFile;
            $this->reSize($pathFile, $pathLocal);
            //move_uploaded_file($pathFile, $pathLocal);
        } else {
            echo "Ошибка загрузки файла.", "<a href='/reg'>Назад</a>";
            die();
        }
    }
    public function reSize($pathFile, $pathLocal){
        try {
            // create an image manager instance with favored driver
            $manager = new ImageManager(array('driver' => 'gd')); // Вместо "imagick" должно быть прописано "gd"

            // to finally create image instances
            $img = $manager->make($pathFile);

            $img->resize(100, 100);

            $img->save($pathLocal);
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}