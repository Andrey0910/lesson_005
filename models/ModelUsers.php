<?php

namespace App;
//require_once ("../app/db.php");
class ModelUsers
{
    protected $pdo;
    public function __construct()
    {
        $this->connect();
    }
    //Соединение с базой данный
    protected function connect(){
        // подключаем настройки базы данных
        $config = include (__DIR__ . DIRECTORY_SEPARATOR . 'config.php');

        $pdoConfig = (object)$config["db"];

        try {
            //Connect to MySQL using the PDO object.
            $this->pdo = new \PDO(
                sprintf('mysql:host=%s;dbname=%s', $pdoConfig->host,$pdoConfig->dbname),
                $pdoConfig->username,
                $pdoConfig->password
            );
        } catch (PDOException $e) {
            echo "Error connect to database: " . $e->getMessage() . "\n";
            return null;
        }
    }

    public function userExist($login=null, $password=null)
    {
        $prepare = $this->pdo->prepare('SELECT * FROM users_data WHERE login = :login AND password = :password ORDER BY id DESC LIMIT 1');
        $prepare->execute(['login' => $login, 'password' => $password]);
        $data = $prepare->fetchAll(\PDO::FETCH_OBJ);
        return $data;
    }
}