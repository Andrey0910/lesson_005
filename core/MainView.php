<?php

namespace App;
class MainView
{
    public function render($fileName, $data = null)
    {
        if (!empty($data)) {
            extract($data);
        }
        require_once __DIR__ . "/../views/" . $fileName . ".php";
    }
}