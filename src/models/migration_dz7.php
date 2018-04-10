<?php
require __DIR__ . '/../../vendor/autoload.php';
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint;

// подключаем настройки базы данных
$config = include(__DIR__ . DIRECTORY_SEPARATOR . 'config.php');
$dbConfig = (object)$config["db"];
//Соединение с базой данный
$capsule = new Capsule;
$capsule->addConnection([
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
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();
Capsule::schema()->dropIfExists('section_books');

Capsule::schema()->create('section_books', function (Blueprint $table){
    $table->increments('id');
    $table->string('section_name', 255);
    $table->timestamp('created_at');
    $table->timestamp('updated_at');
});
Capsule::schema()->create('books', function (Blueprint $table){
    $table->increments('id');
    $table->integer('section_id');
    $table->string('book_name', 255);
    $table->string('author', 255);
    $table->float('price');
    $table->timestamp('created_at');
    $table->timestamp('updated_at');
});