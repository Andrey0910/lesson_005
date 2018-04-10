<?php

namespace App\Controllers;

use App\Models\UsersModel;

class AuthorizationController extends MainController
{
    public function index($nameView)
    {
        if ($nameView == 'authorization') {
            $this->view->render('authorization');
        } elseif ($nameView == 'reg') {
            $this->view->render('reg');
        }
    }

    public function authorization()
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $modelUsers = new UsersModel();
        $data = $modelUsers->getUserLogin($login);
        $user = null;
        foreach ($data['users'] as $item) {
            $passwordHash = $item->password;
            if (password_verify($password, $passwordHash)) {
                $user = $item;
                break;
            }
        }
        if (empty($user)) {
            $this->redirect("/reg");
        }
        $_SESSION["user"] = $user->login;
        $this->redirect("/list");
    }

    public function logout()
    {
        session_start();
        $_SESSION["user"] = null;
        header("Location: /authorization");
    }
}