<?php

namespace App\Core;
class MainView
{
    public function render($fileName, $data = null)
    {
        $template = TEMPLATE_DIR.DIRECTORY_SEPARATOR.$fileName.".php";
        if (!file_exists($template)){
            throw new NotFound("Немогу найти файл:".$template);
        }
        if (!empty($data)) {
            extract($data);
        }
        require $template;
    }
}