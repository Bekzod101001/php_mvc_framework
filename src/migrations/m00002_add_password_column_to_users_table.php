<?php


use app\core\Migration;

class m00002_add_password_column_to_users_table extends Migration {

    public function up()
    {
        $this->db->pdo->exec("
            ALTER TABLE users ADD COLUMN password TEXT NOT NULL;
        ");
    }

    public function down()
    {
        $this->db->pdo->exec("
            ALTER TABLE users DROP COLUMN password;
        ");
    }

}