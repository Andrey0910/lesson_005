<?php

namespace App;
require("../vendor/autoload.php");

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Manager;

class User extends \Illuminate\Database\Eloquent\Model
{
    protected $table = "users_data";
}

class ModelUsers
{
    protected $pdo;
    protected $capsule;

    public function __construct()
    {

        // подключаем настройки базы данных
        $config = include(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
        $dbConfig = (object)$config["db"];
        //Соединение с базой данный
        $this->capsule = new Capsule;
        $this->capsule->addConnection([
            'driver' => 'mysql',
            'host' => $dbConfig->host,
            'database' => $dbConfig->dbname,
            'username' => $dbConfig->username,
            'password' => $dbConfig->password,
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
        ]);
        // Make this Capsule instance available globally via static methods... (optional)
        $this->capsule->setAsGlobal();

        // Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
        $this->capsule->bootEloquent();
    }

    public function userReg($data)
    {
        try {
            $user = new User();
            $user->login = $data['login'];
            $user->password = $data['password'];
            $user->name = $data['name'];
            $user->age = $data['age'];
            $user->description = $data['description'];
            $user->photo = $data['photo'];
            $user->save();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function getUserLogin($login)
    {
        $data = [];
        try {
            $data = User::where('login', $login)->get();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $data;
    }

    public function getAll()
    {
        $data = [];

        try {
            $data = User::all();
        } catch (\Exception $e) {

            echo $e->getMessage();
        }
        return $data;
    }

    public function rowDelete($id)
    {
        try {
            $user = User::find($id);
            if (!empty($user)) {
                $user->delete();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getAllPhoto()
    {
        $data = [];
        try {
            $data = User::whereNotNull('photo')->get();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $data;
    }

    public function photoDelete($id)
    {
        try {
            $user = User::find($id);
            $user->photo = '';
            $user->save();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}