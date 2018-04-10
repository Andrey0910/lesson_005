<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';

use \App\Core\NotFound;

define('TEMPLATE_DIR', realpath(__DIR__.'/../src/views'));

$app = new \App\Core\Bootstrap();
try {
    $app->run();
}catch (NotFound $a){
    require "../errors/404.php";
} catch (\Exception $e) {
    echo $e->getMessage();
}