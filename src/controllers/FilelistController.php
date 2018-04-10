<?php

namespace App\Controllers;

use App\Models\UsersModel;

class FilelistController extends MainController
{
    public function index($nameView)
    {
        $modelUsers = new UsersModel();
        $data = $modelUsers->getAllPhoto();
        $this->view->render($nameView, $data);

    }

    public function photoDelete($nameView)
    {
        $id = $_GET['id'];
        $photo = $_GET['photo'];

        $modelUsers = new UsersModel();
        $modelUsers->photoDelete($id);
        $pathFile = "../www/photo/" . $photo;
        if (file_exists($pathFile) && !empty($photo)) {
            unlink($pathFile);
        }
        header("Location: /" . $nameView);

    }
}