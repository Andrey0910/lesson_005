<?php
namespace App;
class MainView{
    public function render($fileName, $data){
        echo "hi view";
        extract($data);
        require_once __DIR__."/../views/".$fileName.".php";
    }
}