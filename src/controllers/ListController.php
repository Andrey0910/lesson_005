<?php

namespace App\Controllers;

use App\core\ImsgeResize;
use App\Models\UsersModel;
use App\Core\ImageResize;

class ListController extends MainController
{
    public function index($nameView)
    {
        $modelUsers = new UsersModel();
        $data = $modelUsers->getAll();

        $this->view->render($nameView, $data);
    }

    public function rowDelete($nameView)
    {
        $id = $_GET['id'];
        $photo = $_GET['photo'];
        $modelUsers = new UsersModel();
        $modelUsers->rowDelete($id);
        $pathFile = "../www/photo/" . $photo;
        if (file_exists($pathFile) && !empty($photo)) {
            unlink($pathFile);
        }
        header("Location: /" . $nameView);
    }
    public function addPhoto(){
        $id = $_POST['id'];
        //$photo = $_POST['photo'];
        $photo = (string)random_int(0, 10000) . $_FILES['photo']['name'];
        $img = new ImsgeResize();
        $img->moveFile($photo);
        $modelUsers = new UsersModel();
        $modelUsers->addPhoto($id, $photo);
        header('Location: /list');
    }

    public function orderBy($nameView){
        $fieldName = $_GET['fieldName'];
        $orderBy = $_GET['orderBy'];
        $modelUsers = new UsersModel();
        $data = $modelUsers->getAll($fieldName, $orderBy);

        $this->view->render($nameView, $data);
    }
}