<?php

namespace app\core;

class View
{

    public static function view($view, $params = [], $layout = 'main')
    {
        $view = self::render("$view.php", $params);
        $layout = self::renderLayout($layout);

        return self::renderViewWithLayout($view, $layout);
    }


    public static function renderLayout(string $layout = 'main')
    {
        return self::render("layouts/$layout.php");
    }

    public static function renderViewWithLayout($view, $layout)
    {
        return str_replace("{{content}}", $view, $layout);
    }

    public static function render($path, $params = [])
    {
        ob_start();
        foreach($params as $key => $value) {
            $$key = $value;
        }
        include_once Application::$ROOT_PATH . "/views/$path";
        return ob_get_clean();
    }
}