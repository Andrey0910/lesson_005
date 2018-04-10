<?php

namespace App\Models;

use Illuminate\Database\Capsule\Manager as Capsule;

class UsersModel
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
        $user = new User();
        $user->login = $data['login'];
        $user->password = $data['password'];
        $user->name = $data['name'];
        $user->age = $data['age'];
        $user->description = $data['description'];
        $user->photo = $data['photo'];
        $user->save();
    }


    public function getUserLogin($login)
    {
        $data['users'] = User::where('login', $login)->get();
        return $data;
    }

    public function getAll($fieldName = null, $orderBy = null)
    {
        if (!empty($fieldName) && !empty($orderBy)){
            $data['users'] = User::orderBy($fieldName, $orderBy)->get();
            return $data;
            exit();
        }
        $data['users'] = User::all();
        return $data;
    }

    public function rowDelete($id)
    {
        $user = User::find($id);
        if (!empty($user)) {
            $user->delete();
        }
    }

    public function getAllPhoto()
    {
        $data['photos'] = User::whereNotNull('photo')
            ->where('photo', '<>', '')->get();
        return $data;
    }

    public function photoDelete($id)
    {
        $user = User::find($id);
        $user->photo = '';
        $user->save();
    }

    public function addPhoto($id, $photo){
        $user = User::find($id);
        $user->photo = $photo;
        $user->save();
    }
}