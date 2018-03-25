<?php
namespace App;
class ControllerUsers extends MainController {
    public function php (){
        echo "Hi PHP";
    }
    public function index(){
        echo "Hi INDEX";
        $viewName = "ViewUsers";

        $modelUsers = new ModelUsers();
        $data =[
            "users" => $modelUsers->getAllUsers()
        ];
        $this->view->render($viewName, $data);
    }
}