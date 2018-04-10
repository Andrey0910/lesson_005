<?php
require __DIR__ . '/../../vendor/autoload.php';
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

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
Capsule::schema()->dropIfExists('users_data');

Capsule::schema()->create('users_data', function (Blueprint $table){
    $table->increments('id');
    $table->string('login', 255);
    $table->string('password', 255);
    $table->string('name', 255);
    $table->integer('age');
    $table->string('description', 1000);
    $table->string('photo', 255);
    $table->timestamp('created_at');
    $table->timestamp('updated_at');
});
class User extends Model{
    protected $table = "users_data";
}

for ($i = 0; $i < 10; $i++){
    $facker = Faker\Factory::create();
    $user = new User();
    $user->login = $facker->text(10);
    $user->password = $facker->password;
    $user->name = $facker->name;
    $user->age = $facker->numberBetween(1, 100);
    $user->description = $facker->text;
    $user->photo = $facker->firstName.'.'.$facker->fileExtension;
    $user->save();
}