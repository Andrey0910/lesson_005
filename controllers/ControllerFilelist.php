<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 25.03.2018
 * Time: 19:04
 */

namespace App;


class ControllerFilelist extends MainController
{
    public function index($nameView)
    {
        try {
            $modelUsers = new ModelUsers();
            $data = $modelUsers->getAllPhoto();
            $this->view->render($nameView, $data);
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function photoDelete($nameView)
    {
        $id = $_GET['id'];
        $photo = $_GET['photo'];
        try {
            $modelUsers = new ModelUsers();
            $modelUsers->rowDelete($id);
            $pathFile = "../www/photo/" . $photo;
            if (file_exists($pathFile) && !empty($photo)) {
                unlink($pathFile);
            }
            header("Location: /" . $nameView);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}