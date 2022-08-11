<?php


namespace app\core;

use app\core\interfaces\MigrationInterface;
use app\helpers\Helper;

class Migration implements MigrationInterface
{
    public Database $db;

    public function __construct()
    {
        $this->db = Application::$app->database;
    }

    public function up()
    {
        // TODO: Implement up() method.
    }

    public function down()
    {
        // TODO: Implement down() method.
    }
}