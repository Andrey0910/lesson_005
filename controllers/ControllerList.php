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
    public function index($nameView)
    {
        $modelUsers = new ModelUsers();
        $data = $modelUsers->getAll();

        $this->view->render($nameView, $data);
    }

    public function rowDelete($nameView)
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