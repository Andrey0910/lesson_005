<?php
namespace App;
class MainView{
    public function authorization(){
        require_once __DIR__."/../views/authorization.php";
    }
    public function reg(){
        require_once __DIR__."/../views/reg.php";
    }
    public function list(){
        require_once __DIR__."/../views/list.php";
    }
    public function fileList(){
        require_once __DIR__."/../views/filelist.php";
    }
    public function render($fileName, $data = null)
    {
        if (!empty($data)) {
            extract($data);
        }
        require_once __DIR__."/../views/".$fileName.".php";
    }
}