<?php

namespace app\core\form;

use app\core\form\Field;

class Form
{
    public static function begin($action, $method)
    {
        echo "<form action='$action' method='$method'>";

        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

}